<template>
    <div v-if="hasErrors">
        <!-- <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul> -->
        <p class="mt-3 list-disc list-inside text-sm text-red-600">
            {{ validate }}
        </p>
    </div>
</template>

<script>
export default {
    props: ["validate"],
    computed: {
        errors() {
            return this.$page.props.errors;
        },

        hasErrors() {
            return Object.keys(this.errors).length > 0;
        },
    },
};
</script>
