<header class="bg-white relative flex justify-between lg:gap-2 items-center px-4 py-3 shadow z-10">

    <div class="hidden lg:flex lg:justify-start gap-2">
        <button id="openSidebar" class="justify-start items-center w-7 h-7">
            <i class="fa-solid fa-bars text-gray-600"></i>
        </button>
    </div>

    <div id="dropdownTrigger" class="flex items-center gap-2 cursor-pointer">
        <i class="fa-solid fa-user text-gray-600"></i>
        <span><?= $_SESSION['user']['name'] ?></span>
        <button class="p-2">
            <i class="fa-solid fa-chevron-down text-gray-600"></i>
        </button>
    </div>

    <div id="dropdown"
        class="border border-gray-300 absolute right-6 top-16 duration-100 ease-in w-40 bg-white shadow-md rounded overflow-hidden divide-y gap-2 hidden">
        <a href="/logout" class="py-2 hover:bg-gray-200 px-4 block">
            <button class="text-tes">Çıkış</button>
        </a>
    </div>

</header>