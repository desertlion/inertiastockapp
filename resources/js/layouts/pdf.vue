<template>
    <div class="flex h-screen bg-gray-100 font-sans">

            <!--Dash Content -->
            <div id="dash-content" class="py-6 lg:py-0 w-full flex flex-wrap content-start min-h-screen bg-gray-200">
                <slot></slot>
            </div>

        </div>

    </div>
</template>


<script>
    export default {
        name: 'PDF',
    }
</script>
