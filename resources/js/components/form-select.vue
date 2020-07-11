<template>
    <label class="block">
        <span v-if="label" class="block text-gray-700 text-sm font-bold mb-2" v-text="label"></span>

        <select class="form-select"
                :class="{ 'border-red-500 mb-1': errors.length }"
                v-bind="$attrs"
                v-on="{ ...$listeners, input: event => $emit('input', event.target.value) }">
            <slot></slot>
        </select>
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
