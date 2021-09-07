<template>
    <i :href="href" :class="classess"> </i>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },

    props: ["href", "active"],

    computed: {
        classess() {
            return this.active ? "opacity-75" : "text-blueGray-300";
        },
    },
};
</script>
