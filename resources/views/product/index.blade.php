@extends('app')

@section('app_content')

    <div class="bg-white shadow-md rounded px-3 md:px-8 pt-3 md:pt-6 pb-3 md:pb-8 mb-4">

        <div class="mb-4">

            <h2 class="text-blue-600 text-lg font-bold mb-3 border-b border-gray-400 pb-2">Products</h2>

            <!-- SEARCH FORM -->

            <search-form
                group="product-search"
                url="{{ route('product.fetch') }}"
                :params="{
                    search: '',
                    per_page: {{ $defaultPerPage }},
                    page: 1,
                    order_by: 'name:asc'
                    }"
                v-slot="{ params, update, change, clear, processing }"
            >

                <form class="grid grid-cols-8 col-gap-4 pb-3 border-b border-gray-400">
                    <div class="col-span-8 md:col-span-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="search">
                            Recherche
                        </label>
                        <div class="relative">
                            <span
                                v-if="params.search"
                                @click="clear({ search: '' })"
                                class="absolute top-0 right-0 mt-4 mr-4 text-gray-500 cursor-pointer"
                            >
                                <times-circle
                                    class="fill-current h-4 pointer-events-none"
                                ></times-circle>
                            </span>
                            <input
                                v-model="params.search"
                                @input="update"
                                @keydown.enter.prevent
                                type="text"
                                id="search"
                                name="search"
                                class="appearance-none block w-full bg-gray-200 focus:bg-white text-gray-700 border border-gray-400 focus:border-gray-500 rounded-sm py-3 pl-4 pr-10 mb-3 md:mb-0 leading-tight focus:outline-none"
                                placeholder="Rechercher..."
                            >
                        </div>
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <label
                            for="order_by"
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        >
                            Trier par
                        </label>
                        <div class="relative">
                            <select
                                v-model="params.order_by"
                                @change="change"
                                id="order_by"
                                class="appearance-none block w-full bg-gray-200 focus:bg-white text-gray-700 border border-gray-400 focus:border-gray-500 rounded-sm py-3 pl-4 pr-8 leading-tight focus:outline-none"
                            >
                                <option value="name:asc">Name ASC</option>
                                <option value="name:desc">Name DESC</option>
                                <option value="price:asc">Price ASC</option>
                                <option value="price:desc">Price DESC</option>
                            </select>
                            <select-angle></select-angle>
                        </div>
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <label
                            for="per_page"
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        >
                            Par Page
                        </label>
                        <div class="relative">
                            <select
                                v-model="params.per_page"
                                @change="change"
                                id="per_page"
                                class="appearance-none block w-full bg-gray-200 focus:bg-white text-gray-700 border border-gray-400 focus:border-gray-500 rounded-sm py-3 pl-4 pr-8 leading-tight focus:outline-none"
                            >
                                <option
                                    v-for="perPage in {{ $perPage }}"
                                    :value="perPage"
                                >@{{ perPage }}</option>
                            </select>
                            <select-angle></select-angle>
                        </div>
                    </div>
                </form>

            </search-form>

            <!--/ SEARCH FORM -->


            <!-- RESULTS -->

            <search-results
                group="product-search"
                v-slot="{ total, records }"
            >

                <div class="text-sm">

                    <div class="flex flex-wrap p-4 bg-gray-700 text-white rounded-sm">
                        <div class="flex-auto pr-3">
                            Total : @{{ total }}
                        </div>
                    </div>

                    <template v-if="records.length">

                        <div
                            v-for="record in records"
                            :key="record.id"
                            class="flex flex-wrap p-4 border-b border-dashed border-gray-400 text-gray-700 hover:bg-gray-100"
                        >
                            <div class="flex-auto pr-3">
                                @{{ record.name }} (&pound;@{{ record.price }})
                            </div>
                            <div class="flex-shrink">
                                <a
                                    :href="record.edit_url"
                                    class="inline-block mr-3 text-green-500"
                                >
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a
                                    :href="record.destroy_url"
                                    class="inline-block text-red-500">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>

                    </template>

                    <div
                        v-else
                        class="flex flex-wrap p-4 border-b border-dashed border-gray-400 text-gray-700"
                    >
                        There are no records available
                    </div>

                </div>

            </search-results>

            <!--/ RESULTS -->


            <!-- PAGINATION -->

            <search-pagination group="product-search" :always-show="true"></search-pagination>

            <!--/ PAGINATION -->

        </div>

    </div>

@endsection
