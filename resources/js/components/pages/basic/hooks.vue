<template>
    <div>
        <h1 ref="myref">Hooks Tutorial</h1>
        <p>Mys name is: {{ name }}</p>
    </div>
</template>

<script>
    export default ({
        data() {
            return {
                name: 'Sindhu B'
            }
        }, 
        beforeCreate() {
            // use for check login status and route to other page
            console.log(this.name)
        },
        created() {
            // call mostly initial data from it...
            console.log('data and other function is avilable but not html', this.name)
        }, 
        mounted() {
            // 
            console.log(this.$refs.myref)
        }
    })
</script>
