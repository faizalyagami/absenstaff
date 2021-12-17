<style>
    .demo-upload-list{
        display: inline-block;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
</style>

<template>
	<div>
		<div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Categories <Button @click="addModal = true"><Icon type="md-add" /> Add Category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>Id</th>
								<th>Icon Image</th>
								<th>Category Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
							<tr v-for="(category, i) in categories" :key="i" v-if="categories.length">
								<td>{{ category.id }}</td>
								<td class="table_image">
									<img :src="category.icon_image" alt="" />
								</td>
								<td class="_table_name">{{ category.category_name }}</td>
								<td>{{ category.created_at }}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(category, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeleteModal(category, i)" :loading="category.isDeleting">Delete</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>

				<!-- Category adding modal -->
				<Modal
					v-model="addModal"
					title="Add Category"
					:mask-closable = "false"
					:closable = "false">

					<Input v-model="data.category_name" placeholder="Add Category name.." />
                    <div class="space" style="margin: 10px;"></div>
                    <Upload
						ref="uploads"
                        type="drag"
                        :headers = "{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest'}"
						:on-success="handleSuccess"
						:on-error="handleError"
						:format="['jpg','jpeg','png']"
						:max-size="2048"
						:on-format-error="handleFormatError"
						:on-exceeded-size="handleMaxSize"
                        action="/app/upload">
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>

					<div class="demo-upload-list" v-if="data.icon_image">
						<img :src="`${data.icon_image}`" alt="" />
						<div class="demo-upload-list-cover">
							<Icon type="ios-trash-outline" @click="deleteImage"></Icon>
						</div>
					</div>

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Add Category'}}</Button>
					</div>
				</Modal>

				<!-- Category editing modal -->
				<Modal
					v-model="editModal"
					title="Edit Category"
					:mask-closable = "false"
					:closable = "false">

					<Input v-model="editData.category_name" placeholder="Edit Category name..." />
                    <div class="space" style="margin: 10px;"></div>
                    <Upload v-show="isIconImageNew"
						ref="editDataUploads"
                        type="drag"
                        :headers = "{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest'}"
						:on-success="handleSuccess"
						:on-error="handleError"
						:format="['jpg','jpeg','png']"
						:max-size="2048"
						:on-format-error="handleFormatError"
						:on-exceeded-size="handleMaxSize"
                        action="/app/upload">
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>

					<div class="demo-upload-list" v-if="editData.icon_image">
						<img :src="`${editData.icon_image}`" alt="" />
						<div class="demo-upload-list-cover">
							<Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
						</div>
					</div>

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Edit Category'}}</Button>
					</div>
				</Modal>

				<!-- Category delete modal -->
				<!-- <Modal v-model="deleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure want to delete this Category?</p>
					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteCategory">Delete</Button>
					</div>
				</Modal> -->
				<deleteModal></deleteModal>

			</div>
		</div>
	</div>
</template>

<script>
import { mapGetters } from 'vuex';
import deleteModal from '../components/deleteModal.vue'

export default {
	data() {
		return {
			data: {
				category_name: '', 
				icon_image: '', 
			}, 
			editData: {
				category_name: '', 
				icon_image: '', 
			},
			addModal: false, 
			editModal: false, 
			deleteModal: false, 
			isAdding: false,
			categories: [], 
			index: -1, 
			deleteItem: {},
			deleteIndex: -1, 
			isDeleting: false,
            token: '',
			isIconImageNew: false, 
			isEditingItem: false, 
		}
	}, 
	methods: {
		async addCategory() {
			if(this.data.category_name.trim() == '') return this.error('Category name is required');
			if(this.data.icon_image.trim() == '') return this.error('Icon image is required');
			this.data.icon_image = this.data.icon_image
			const res = await this.callApi('post', 'app/create_category', this.data)
			if(res.status === 201) {
				this.categories.unshift(res.data)
				this.success('Category has been added successfully!')
				this.addModal = false
				this.data.category_name = ''
				this.data.icon_image = ''
			} else {
				if(res.status == 422) {
					if(res.data.errors.category_name) {
						this.error(res.data.errors.category_name[0]);
					}

					if(res.data.errors.icon_image) {
						this.error(res.data.errors.icon_image[0]);
					}
				} else {
					this.swr();
				}
			}
		}, 
		async editCategory() {
			if(this.editData.category_name.trim() == '') return this.error('Category name is required');
			if(this.editData.icon_image.trim() == '') return this.error('Icon image is required');
			const res = await this.callApi('post', 'app/edit_category', this.editData)
			if(res.status === 201) {
				this.categories[this.index].category_name = this.editData.category_name
				this.success('Category has been edited successfully!')
				this.editModal = false
			} else {
				if(res.status == 422) {
					if(res.data.errors) {
						if(res.data.errors.category_name) {
							this.error(res.data.errors.category_name[0]);
						}

						if(res.data.errors.swr) {
							this.error(res.data.errors.swr);
						}
					}
				} else {
					this.swr();
				}
			}
		}, 
		showEditModal(category, index) {
			let obj = {
				id: category.id,
				category_name: category.category_name,
				icon_image: category.icon_image
			}
			this.editData = obj
			this.editModal = true
			this.index = index
			this.isEditingItem = true
		}, 
		async deleteCategory() { // async deleteCategory(Category, index) {
			// if(!confirm('Are you sure want to delete this category?')) return 
			// this.$set(category, 'isDeleting', true)
			this.isDeleting = true
			const res = await this.callApi('post', 'app/delete_category', this.deleteItem)
			if(res.status === 201) {
				this.categories.splice(this.deleteIndex, 1)
				this.success('Category has been deleted successfully!')
			} else {
				this.swr();
			}

			this.isDeleting = false
			this.deleteModal = false
		}, 
		showDeleteModal(category, index) {
			const deleteModalObj = {
				showDeleteModal: true, 
				deleteUrl: 'app/delete_category', 
				data: category, 
				deleteIndex: index, 
				isDeleted: false,
			}
			this.$store.commit('setDeletingModal', deleteModalObj)

			// this.deleteItem = category
			// this.deleteIndex = index
			// this.deleteModal = true
		},
		closeModal() {
			this.addModal = false
			this.editModal = false
			this.data.category_name = ''
			this.data.icon_image = ''
			this.isEditingItem = false
		}, 
		handleSuccess (res, file) {
			res = `/uploads/${res}`
			if(this.isEditingItem) {
				return this.editData.icon_image = res
			}
			this.data.icon_image = res
		},
		handleError (res, file) {
			this.$Notice.warning({
				title: 'The file format is incorrect',
				desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong.' }`
			});
		},
		handleFormatError (file) {
			this.$Notice.warning({
				title: 'The file format is incorrect',
				desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
			});
		},
		handleMaxSize (file) {
			this.$Notice.warning({
				title: 'Exceeding file size limit',
				desc: 'File  ' + file.name + ' is too large, no more than 2M.'
			});
		},
		async deleteImage (isAdd = true) {
			var image = ''
			if(!isAdd) {
				this.isIconImageNew = true
				image = this.editData.icon_image
				this.editData.icon_image = ''
				this.$refs.editDataUploads.clearFiles();
			} else {
				image = this.data.icon_image
				this.data.icon_image = ''
				this.$refs.uploads.clearFiles();
			}

			const res = await this.callApi('post', 'app/delete_image', {image_name: image})
			if(res.status !== 200) {
				this.data.icon_image = image
				this.swr()
			}
		}
	},
	async created() {
        this.token = window.Laravel.csrfToken
		const res = await this.callApi('get', 'app/get_categories')
		if(res.status === 200) {
			this.categories =res.data
		} else {
			this.swr();
		}
	}, 
	components: {
		deleteModal
	}, 
	computed: {
		...mapGetters(['getDeleteModalObj'])
	}, 
	watch: {
		getDeleteModalObj(obj) {
			if(obj.isDeleted) {
				console.log(obj.deleteIndex)
				this.categories.splice(obj.deleteIndex, 1)
			}
		}
	}
}
</script>