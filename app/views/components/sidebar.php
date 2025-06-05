<aside id="sidebar"
    class="bg-white absolute w-64 h-dvh p-4 top-0 left-0 flex flex-col overflow-y-hidden ease-linear lg:static -translate-x-full lg:translate-x-0 z-[999] duration-300 ease-linear shadow-lg">
    <div class="flex items-center justify-between py-2.5 px-2">
        <h1 class="font-bold text-xl">SELOJI-MVC</h1>
        <button id="closeSidebar" onclick="closeSidebar()" class="lg:hidden">
            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                    fill="#1c2434" />
            </svg>
        </button>
    </div>
    <div class="space-y-2 mt-4">
        <a href="/dashboard" data-route="/dashboard" aria-label="dashboard"
            class="px-4 py-3 flex items-center space-x-4 rounded-lg hover:bg-gray-100">
            <span class="-mr-1 font-medium">Dashboard</span>
        </a>
        <a href="/products" data-route="/products" aria-label="products"
            class="px-4 py-3 flex items-center space-x-4 rounded-lg hover:bg-gray-100">
            <span class="-mr-1 font-medium">Products</span>
        </a>
        <a href="/isler" data-route="/isler" aria-label="isler"
            class="px-4 py-3 flex items-center space-x-4 rounded-lg hover:bg-gray-100">
            <span class="-mr-1 font-medium">İşler</span>
        </a>
    </div>
</aside>