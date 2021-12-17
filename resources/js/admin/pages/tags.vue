<template>
	<div>
		<div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button @click="addModal = true"><Icon type="md-add" /> Add Tag</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>Id</th>
								<th>Tag Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
							<tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
								<td>{{ tag.id }}</td>
								<td class="_table_name">{{ tag.tag_name }}</td>
								<td>{{ tag.created_at }}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(tag, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeleteModal(tag, i)" :loading="tag.isDeleting">Delete</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>

				<!-- Tag adding modal -->
				<Modal
					v-model="addModal"
					title="Add Tag"
					:mask-closable = "false"
					:closable = "false">

					<Input v-model="data.tagName" placeholder="Add tag name.." />

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Add Tag'}}</Button>
					</div>
				</Modal>

				<!-- Tag editing modal -->
				<Modal
					v-model="editModal"
					title="Edit Tag"
					:mask-closable = "false"
					:closable = "false">

					<Input v-model="editData.tagName" placeholder="Edit tag name.." />

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Add Tag'}}</Button>
					</div>
				</Modal>

				<!-- Tag delete modal -->
				<!-- <Modal v-model="deleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure want to delete this tag?</p>
					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
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
				tagName: ''
			}, 
			editData: {
				tagName: ''
			},
			addModal: false, 
			editModal: false, 
			deleteModal: false, 
			isAdding: false,
			tags: [], 
			index: -1, 
			deleteItem: {},
			deleteIndex: -1, 
			isDeleting: false
		}
	}, 
	methods: {
		async addTag() {
			if(this.data.tagName.trim() == '') return this.error('Tag name is required');
			const res = await this.callApi('post', 'app/create_tag', this.data)
			if(res.status === 201) {
				this.tags.unshift(res.data)
				this.success('Tag has been added successfully!')
				this.addModal = false
				this.data.tagName = ''
			} else {
				if(res.status == 422) {
					if(res.data.errors.tagName) {
						this.error(res.data.errors.tagName[0]);
					}
				} else {
					this.swr();
				}
			}
		}, 
		async editTag() {
			if(this.editData.tagName.trim() == '') return this.error('Tag name is required');
			const res = await this.callApi('post', 'app/edit_tag', this.editData)
			if(res.status === 201) {
				this.tags[this.index].tag_name = this.editData.tagName
				this.success('Tag has been edited successfully!')
				this.editModal = false
			} else {
				if(res.status == 422) {
					if(res.data.errors) {
						if(res.data.errors.tagName) {
							this.error(res.data.errors.tagName[0]);
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
		showEditModal(tag, index) {
			let obj = {
				id: tag.id,
				tagName: tag.tag_name
			}
			this.editData = obj
			this.editModal = true
			this.index = index
		},  
		showDeleteModal(tag, index) {
			const deleteModalObj = {
				showDeleteModal: true, 
				deleteUrl: 'app/delete_tag', 
				data: tag, 
				deleteIndex: index, 
				isDeleted: false,
			}
			this.$store.commit('setDeletingModal', deleteModalObj)

			// this.deleteItem = tag
			// this.deleteIndex = index
			// this.deleteModal = true
		},
		closeModal() {
			this.addModal = false
			this.editModal = false
			this.data.tagName = ''
		}
	},
	async created() {
		const res = await this.callApi('get', 'app/get_tags')
		if(res.status === 200) {
			this.tags =res.data
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
				this.tags.splice(obj.deleteIndex, 1)
			}
		}
	}
}
</script>