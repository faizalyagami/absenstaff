<template>
    <div>
        Homepage
    </div>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            //
        }
    },
    created() {
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    },
    methods: {}
}
</script>