<template>
    <div>
        <Modal 
            :value="getDeleteModalObj.showDeleteModal" 
            :mask-closable = "false" 
            :closable = "false" 
            width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete confirmation</span>
            </p>
            <div style="text-align:center">
                <p>Are you sure want to delete this Category?</p>
            </div>
            <div slot="footer">
                <Button type="default" @click="closeModal">Close</Button>
                <Button type="error" size="large" :loading="isDeleting" :disabled="isDeleting" @click="deleteCategory">Delete</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                isDeleting: false,
            }
        }, 
        methods: {
            async deleteCategory() {
                this.isDeleting = true
                const res = await this.callApi('post', this.getDeleteModalObj.deleteUrl, this.getDeleteModalObj.data)
                if(res.status === 201) {
                    this.success('Category has been deleted successfully!')
                    this.$store.commit('setDeleteModal', true)
                } else {
                    this.swr();
                    this.$store.commit('setDeleteModal', false)
                }
                this.isDeleting = false
            },
            closeModal() {
                this.$store.commit('setDeleteModal', false)
            }
        }, 
        computed: {
            ...mapGetters(['getDeleteModalObj'])
        }, 
    }
</script>