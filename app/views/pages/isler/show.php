<?php
$title = 'Products';
ob_start();
?>

<section class="bg-white rounded p-4 shadow-lg grid md:grid-cols-2 gap-4">
    <div class="flex justify-center items-start overflow-hidden rounded-md">
        <img src="/<?= $product->thumbnail ?>" alt="Thumbnail">
    </div>
    <div class="relative">
        <div class="mb-2">
            <h3 class="font-semibold">Name:</h3>
            <span><?= $product->name ?></span>
        </div>
        <div class="mb-2">
            <h3 class="font-semibold">Price:</h3>
            <span>$<?= $product->price ?></span>
        </div>
        <div class="mb-2">
            <h3 class="font-semibold">Description:</h3>
            <span><?= $product->description ?></span>
        </div>
        <div class="absolute bottom-0 right-0 flex justify-center items-center gap-2">
            <button id="openProductModalEdit"
                class="px-3 py-1 rounded border border-cyan-500 hover:bg-cyan-500 text-cyan-500 hover:text-white font-medium">
                Edit
            </button>
            <a href="/products"
                class="px-3 py-1 rounded bg-cyan-500 border border-cyan-500 hover:bg-cyan-600 text-white font-medium">
                Back
            </a>
        </div>
    </div>
</section>

<div id="productModalEdit"
    class="fixed z-[9999] inset-0 hidden bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-1/4 -translate-y-1/4 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">UPDATE PRODUCT</h3>
        <form action="/products/<?= $product->id ?>" method="post" enctype="multipart/form-data">
            <input type="text" name="_method" value="UPDATE" hidden>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 p-2 border w-full rounded-md"
                    value="<?= $product->name ?>" required>
            </div>
            <div class="mb-4">
                <label for="thumbnail" class="block text-sm font-medium text-gray-700">Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-black"
                    required>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="text" id="price" name="price" class="mt-1 p-2 border w-full rounded-md"
                    value="<?= $product->price ?>" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="mt-1 p-2 border w-full rounded-md"><?= $product->description ?></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeProductModalEdit"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded mr-2">
                    Cancel
                </button>
                <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded">
                    Add
                </button>
            </div>
        </form>
    </div>
</div>

<?php
ob_start();
?>
<script>
    $(document).ready(function () {
        $('#openProductModalEdit').click(function () {
            $('#productModalEdit').removeClass('hidden');
        });

        $('#closeProductModalEdit').click(function () {
            $('#productModalEdit').addClass('hidden');
        });

        $(window).click(function (event) {
            if (event.target.id == 'productModalEdit') {
                $('#productModalEdit').addClass('hidden');
            }
        });
    })
</script>
<?php
$scripts = ob_get_clean();
?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/authenticated.php';
?>