<template>
    <div>
        <div class="content">
			<div class="container-fluid">
                <h1>I wull show how all other components react to changes</h1>
                <h2>The master component : {{ counter }}</h2>

                <div>
                    <comA></comA>
                </div>
                <div>
                    <comB></comB>
                </div>
                <div>
                    <comC></comC>
                </div>

                <Button type="info" @click="changeCounter">Change the state of the counter</Button>
            </div>
        </div>
    </div>
</template>

<script>
    import comA from './comA'
    import comB from './comB'
    import comC from './comC'
    import {mapGetters, mapActions} from 'vuex'

    export default {
        data () {
            return {
                localVar: 'Local Var'
            }
        }, 
        computed: {
            // ...mapGetters(['getCounter', 1]) // normal variable
            ...mapGetters({
                'counter': 'getCounter'
            }) // custome variable
        },
        methods: {
            changeCounter () {
                this.$store.dispatch('changeTheCounterAction', 1)
                // this.$store.commit('changeTheCounter', 1)
            }, 
            runSomethingWhenCountChange() {
                console.log('I am running base on each changes happening')
            }
        },
        created () {
            console.log(this.$store)
        },
        components: {
            comA, 
            comB, 
            comC, 
        }, 
        watch: {
            counter(value) {
                console.log('counter is changing', value)
                this.runSomethingWhenCountChange()
                console.log('This is local variable', this.localVar)
            }
        }
    }
</script>