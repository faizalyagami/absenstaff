<template>
    <div>
        <h1>Methods Tutorial...</h1>

        <h2>The number is: {{ views }}</h2>
        <button @click="updateCounter(1)">Increase</button>
        <button @click="updateCounter(-1)">Decrease</button>

        <br><br><br>

        <div v-for="(blog, index) in blogs" :key="index" v-if="blogs.length">
            <h1>{{ blog.title }}</h1>
            <p>{{ blog.post }}</p>
        </div>

        <br><br><br>

        <div>
            <h1 v-if="showItem">Shwo this item if "showItem" is true</h1>
            <h1 v-else>Shwo this item if "showItem" is false</h1>
        </div>
        <button @click="showItem = !showItem">Change showItem</button>
        <button @click="changeShowItem">Change showItem via function</button>

    </div>
</template>

<script>
export default {
    data() {
        return {
            views: 0, 
            blogs: [],
            showItem: false
        }
    },
    methods: {
        updateCounter(number) {
            this.views += number
        }, 
        changeShowItem() {
            this.showItem = !this.showItem
        }
    }, 
    created() {
        // call the server to get views of this blog post
        this.views = 100

        // get the blog posts
        let posts = [
            {title: 'this is blog title 1', 'post': 'this is the blog post 1', id: 1}, 
            {title: 'this is blog title 2', 'post': 'this is the blog post 2', id: 2}, 
            {title: 'this is blog title 3', 'post': 'this is the blog post 3', id: 3}, 
            {title: 'this is blog title 4', 'post': 'this is the blog post 4', id: 4}, 
            {title: 'this is blog title 5', 'post': 'this is the blog post 5', id: 5}, 
        ]
        this.blogs = posts
    }
}
</script>