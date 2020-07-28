<template>
    <label class="block">
        <span v-if="label" class="block text-gray-700 text-sm font-bold mb-2" v-text="label"></span>

        <datetime class="text-sm appearance-none border rounded w-full py-3 bg-gray-100 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
                :class="{ 'border-red-500 mb-1': errors.length }"
                v-bind="$attrs"
               />

        <p v-if="errors.length" class="text-red-500 text-xs italic pl-1" v-text="errors[0]"></p>
    </label>
</template>

<script>
    export default {
        /**
         * Determine if the attributes are passed to the root component.
         *
         * @type {Boolean}
         */
        inheritAttrs: false,

        /**
         * Component properties.
         *
         * @type {Object}
         */
        props: {
            id: String,
            label: String,
            errors: {
                type: Array,
                default: () => ([]),
            },
        },
    }
</script>
