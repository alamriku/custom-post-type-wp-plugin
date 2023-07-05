<div class="relative z-10 hidden" id="post_modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!--
      Background backdrop, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto modal-content">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0 ">
            <!--
              Modal panel, show/hide based on modal state.

              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-3/4">
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button data-button-post="<?php echo $post->ID ?>" type="button" class="button_custom_color mt-3 inline-flex w-full justify-center rounded-md bg-red px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto close">Cancel</button>
                </div>
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="pt-6 pb-16 sm:pb-24">
                        <div class="mt-8 max-w-2xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                            <div class="lg:grid lg:grid-cols-12 lg:auto-rows-min lg:gap-x-8">
                                <div class="lg:col-start-8 lg:col-span-5">
                                    <!-- Reviews -->
                                    <div class="mt-4">
                                        <div class="flex items-center">
                                            <h1 class="text-xl font-medium text-gray-900" id="post_title"></h1>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image gallery -->
                                <div class="mt-8 lg:mt-0 lg:col-start-1 lg:col-span-7 lg:row-start-1 lg:row-span-3">
                                    <h2 class="sr-only">Images</h2>

                                    <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
                                        <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-featured-product-shot.jpg" id="preview_image" alt="Back of women&#039;s Basic Tee in black." class="lg:col-span-2 lg:row-span-2 rounded-lg">
                                        <div class="grid grid-cols-3 sm:grid-cols-2 md:grid-cols-3  gap-4 border-gray-200 rounded p-2 text-center">
                                            <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-featured-product-shot.jpg" id="thumbnail_image" alt="Back of women&#039;s Basic Tee in black." class="lg:col-span-2 lg:row-span-2 rounded">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 lg:col-span-5">
                                    <form>
                                        <!-- Color picker -->
                                        <div>
                                            <h2 class="text-sm font-medium text-gray-900">Category</h2>

                                            <fieldset class="mt-2">
                                                <legend class="sr-only">Choose a color</legend>
                                                <div class="flex items-center space-x-3" id="post_category">

                                                </div>
                                            </fieldset>
                                        </div>

                                    </form>

                                    <!-- Product details -->
                                    <div class="mt-10">
                                        <h2 class="text-sm font-medium text-gray-900">Description</h2>

                                        <div class="mt-4 prose prose-sm text-gray-500" id="post_content">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button data-button-post="<?php echo $post->ID ?>" type="button" class="button_custom_color mt-3 inline-flex w-full justify-center rounded-md bg-red px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
