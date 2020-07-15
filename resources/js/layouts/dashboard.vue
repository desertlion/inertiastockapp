<template>
    <div class="flex h-screen bg-gray-100 font-sans">

        <!-- Side bar-->
        <div id="sidebar" class="h-screen w-16 menu bg-white text-white px-4 flex items-center nunito static fixed shadow">

            <ul class="list-reset ">
                <li class="my-2 md:my-0">
                    <inertia-link class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400" :href="$route('home')">
                        <i class="fas fa-home fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Home</span>
                    </inertia-link>
                </li>
                <li class="my-2 md:my-0 ">
                    <inertia-link class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400" :href="$route('pegawai')">
                        <i class="fas fa-users fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Pegawai</span>
                    </inertia-link>
                </li>
                <li class="my-2 md:my-0 ">
                    <inertia-link class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400" :href="$route('products.index')">
                        <i class="fas fa-tasks fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Barang</span>
                    </inertia-link>
                </li>
                <li class="my-2 md:my-0 ">
                    <inertia-link class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400" :href="$route('incomingwares.index')">
                        <i class="fas fa-fw mr-3"><img src="../../svg/icon_stock_in_16.svg" /></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Barang Masuk</span>
                    </inertia-link>
                </li>
                <li class="my-2 md:my-0 ">
                    <inertia-link class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400" :href="$route('orders.index')">
                        <i class="fas fa-fw mr-3"><img src="../../svg/icon_stock_out_16.svg" /></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Permintaan</span>
                    </inertia-link>
                </li>
                <li class="my-2 md:my-0 ">
                    <inertia-link class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400" :href="$route('deliveries.index')">
                        <i class="fas fa-fw fa-truck mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Penyerahan</span>
                    </inertia-link>
                </li>
                <li class="my-2 md:my-0">
                    <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                        <i class="fa fa-envelope fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Messages</span>
                    </a>
                </li>
                <li class="my-2 md:my-0">
                    <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                        <i class="fas fa-chart-area fa-fw mr-3 text-indigo-400"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Analytics</span>
                    </a>
                </li>
                <li class="my-2 md:my-0">
                    <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                        <i class="fa fa-wallet fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Payments</span>
                    </a>
                </li>
            </ul>

        </div>

        <div class="flex flex-row flex-wrap flex-1 flex-grow content-start pl-16 bg-gray-200">

            <div class="h-40 lg:h-20 w-full flex flex-wrap mb-6">
                <nav id="header1" class="bg-gray-100 w-auto flex-1 border-b-1 border-gray-300 order-1 lg:order-2">

                    <div class="flex h-full justify-between items-center shadow">

                        <!--Search-->
                        <inertia-link href="/home" class="text-lg font-bold pl-5 text-gray-700">Kantor Wilayah Direktorat Jenderal Bea dan Cukai Sumatera Bagian Timur</inertia-link>
                        <!-- / Search-->

                        <!--Menu-->

                        <div class="flex relative inline-block pr-6">

                            <div class="relative text-sm">
                                <button id="userButton" class="flex items-center focus:outline-none mr-3" @click="toggleUserMenu">
                                    <img class="w-8 h-8 rounded-full mr-4" src="/img/300.jpeg" alt="Avatar of User"> <span class="hidden md:inline-block">Hi, {{ $page.user.name }}</span>
                                    <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                        <g>
                                            <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"></path>
                                        </g>
                                    </svg>
                                </button>
                                <div id="userMenu" class="bg-white nunito rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30" v-if="isUserMenuActive">
                                    <ul class="list-reset">
                                        <li><a href="#" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">My account</a></li>
                                        <li><a href="#" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">Notifications</a></li>
                                        <li>
                                            <hr class="border-t mx-2 border-gray-400">
                                        </li>
                                        <li><button @click="$inertia.post($route('logout'))" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline w-full">Logout</button></li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <!-- / Menu -->

                    </div>

                </nav>
            </div>

            <!--Dash Content -->
            <div id="dash-content" class="py-6 lg:py-0 w-full flex flex-wrap content-start min-h-screen bg-gray-200">
                <slot></slot>
            </div>

        </div>

    </div>
</template>


<script>
    export default {
        name: 'Dashboard',
        data: () => ({
            isUserMenuActive: false,
        }),
        methods: {
            toggleUserMenu() { this.isUserMenuActive = !this.isUserMenuActive; }
        }
    }
</script>
