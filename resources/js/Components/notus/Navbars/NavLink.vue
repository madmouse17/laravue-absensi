<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },

    props: ["href", "active"],

    computed: {
        classes() {
            return this.active
                ? "text-emerald-500 hover:text-emerald-600"
                : "text-blueGray-700 hover:text-blueGray-500";
        },
    },
};
</script>
