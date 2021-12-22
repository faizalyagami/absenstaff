<template>
	<div>
		<div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Roles <Button @click="addModal = true"><Icon type="md-add" /> Add Role</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>Id</th>
								<th>Role Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
							<tr v-for="(role, i) in roles" :key="i" v-if="roles.length">
								<td>{{ role.id }}</td>
								<td class="_table_name">{{ role.role_name }}</td>
								<td>{{ role.created_at }}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(role, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeleteModal(role, i)" :loading="role.isDeleting">Delete</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>

				<!-- Role adding modal -->
				<Modal
					v-model="addModal"
					title="Add Role"
					:mask-closable = "false"
					:closable = "false">

					<Input v-model="data.role_name" placeholder="Add role name.." />

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="addRole" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Add Role'}}</Button>
					</div>
				</Modal>

				<!-- Role editing modal -->
				<Modal
					v-model="editModal"
					title="Edit Role"
					:mask-closable = "false"
					:closable = "false">

					<Input v-model="editData.role_name" placeholder="Edit role name.." />

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="editRole" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Edit Role'}}</Button>
					</div>
				</Modal>

				<!-- Role delete modal -->
				<!-- <Modal v-model="deleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure want to delete this role?</p>
					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteRole">Delete</Button>
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
				role_name: ''
			}, 
			editData: {
				role_name: ''
			},
			addModal: false, 
			editModal: false, 
			deleteModal: false, 
			isAdding: false,
			roles: [], 
			index: -1, 
			deleteItem: {},
			deleteIndex: -1, 
			isDeleting: false
		}
	}, 
	methods: {
		async addRole() {
			if(this.data.role_name.trim() == '') return this.error('Role name is required');
			const res = await this.callApi('post', 'app/create_role', this.data)
			if(res.status === 201) {
				this.roles.unshift(res.data)
				this.success('Role has been added successfully!')
				this.addModal = false
				this.data.role_name = ''
			} else {
				if(res.status == 422) {
					if(res.data.errors.role_name) {
						this.error(res.data.errors.role_name[0]);
					}
				} else {
					this.swr();
				}
			}
		}, 
		async editRole() {
			if(this.editData.role_name.trim() == '') return this.error('Role name is required');
			const res = await this.callApi('post', 'app/edit_role', this.editData)
			if(res.status === 201) {
				this.roles[this.index].role_name = this.editData.role_name
				this.success('Role has been edited successfully!')
				this.editModal = false
			} else {
				if(res.status == 422) {
					if(res.data.errors) {
						if(res.data.errors.role_name) {
							this.error(res.data.errors.role_name[0]);
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
		showEditModal(role, index) {
			let obj = {
				id: role.id,
				role_name: role.role_name
			}
			this.editData = obj
			this.editModal = true
			this.index = index
		},  
		showDeleteModal(role, index) {
			const deleteModalObj = {
				showDeleteModal: true, 
				deleteUrl: 'app/delete_role', 
				data: role, 
				deleteIndex: index, 
				isDeleted: false,
			}
			this.$store.commit('setDeletingModal', deleteModalObj)

			// this.deleteItem = role
			// this.deleteIndex = index
			// this.deleteModal = true
		},
		closeModal() {
			this.addModal = false
			this.editModal = false
			this.data.role_name = ''
		}
	},
	async created() {
		const res = await this.callApi('get', 'app/get_roles')
		if(res.status === 200) {
			this.roles =res.data
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
				this.roles.splice(obj.deleteIndex, 1)
			}
		}
	}
}
</script>