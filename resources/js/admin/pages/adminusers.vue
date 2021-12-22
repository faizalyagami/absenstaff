<template>
	<div>
		<div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Admin Users <Button @click="addModal = true"><Icon type="md-add" /> Add Admin</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>Id</th>
								<th>Username</th>
								<th>Level</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
							<tr v-for="(user, i) in users" :key="i" v-if="users.length">
								<td>{{ user.id }}</td>
								<td class="_table_name">{{ user.full_name }}</td>
								<td>{{ user.email }}</td>
								<td>{{ user.role.role_name }}</td>
								<td>{{ user.created_at }}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(user, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeleteModal(user, i)" :loading="user.isDeleting">Delete</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>

				<!-- User adding modal -->
				<Modal
					v-model="addModal"
					title="Add User Admin"
					:mask-closable = "false"
					:closable = "false">

					<div class="space">
                        <Input type="text" v-model="data.full_name" placeholder="Add full name..." />
                    </div>
                    <div class="space">
					    <Input type="text" v-model="data.email" placeholder="Add email..." />
                    </div>
                    <div class="space">
					    <Input type="password" v-model="data.password" placeholder="Add password..." />
                    </div>
                    <div class="space">
					    <Select v-model="data.role_id" placeholder="Select admin type">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{ r.role_name }}</Option>
                        </Select>
                    </div>

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Add Admin'}}</Button>
					</div>
				</Modal>

				<!-- User editing modal -->
				<Modal
					v-model="editModal"
					title="Edit User Admin"
					:mask-closable = "false"
					:closable = "false">

                    <div class="space">
                        <Input type="text" v-model="editData.full_name" placeholder="Edit full name..." />
                    </div>
                    <div class="space">
					    <Input type="text" v-model="editData.email" placeholder="Edit email..." />
                    </div>
                    <div class="space">
					    <Input type="password" v-model="editData.password" placeholder="Edit password..." />
                    </div>
                    <div class="space">
					    <Select v-model="editData.role_id" placeholder="Select admin type">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{ r.role_name }}</Option>
                        </Select>
                    </div>

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Edit User'}}</Button>
					</div>
				</Modal>

				<!-- User delete modal -->
				<!-- <Modal v-model="deleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure want to delete this user?</p>
					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteUser">Delete</Button>
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
				full_name: '', 
				email: '', 
				password: '', 
				role_id: null
			}, 
			editData: {
				full_name: '', 
				email: '', 
				password: '', 
				role_id: null
			},
			addModal: false, 
			editModal: false, 
			deleteModal: false, 
			isAdding: false,
			users: [], 
			index: -1, 
			deleteItem: {},
			deleteIndex: -1, 
			isDeleting: false, 
			roles: []
		}
	}, 
	methods: {
		async addAdmin() {
			if(this.data.full_name.trim() == '') return this.error('Full name name is required');
			if(this.data.email.trim() == '') return this.error('Email is required');
			if(this.data.password.trim() == '') return this.error('Password is required');
			if(!this.data.role_id) return this.error('User type is required');

			const res = await this.callApi('post', 'app/create_user', this.data)
			if(res.status === 201) {
				this.users.unshift(res.data)
				this.success('Admin User has been added successfully!')
				this.addModal = false
				this.data.full_name = ''
				this.data.email = ''
				this.data.password = ''
				this.data.role_id = null
			} else {
				if(res.status == 422) {
                    for (let i in res.data.errors) {
                        this.error(res.data.errors[i][0]);
                    }

                    if(res.data.errors.swr) {
                        this.error(res.data.errors.swr);
                    }
				} else {
					this.swr();
				}
			}
		}, 
		async editAdmin() {
            if(this.editData.full_name.trim() == '') return this.error('Full name name is required');
			if(this.editData.email.trim() == '') return this.error('Email is required');
			if(!this.editData.role_id) return this.error('User type is required');

			const res = await this.callApi('post', 'app/edit_user', this.editData)
			if(res.status === 201) {
                // this.users[this.index] = this.editData // update all by one action
				this.users[this.index].full_name = this.editData.full_name
				this.users[this.index].email = this.editData.email
				this.users[this.index].role_id = this.editData.role_id
				this.success('Admin User has been edited successfully!')
				this.editModal = false
			} else {
				if(res.status == 422) {
					if(res.data.errors) {
						for (let i in res.data.errors) {
                            this.error(res.data.errors[i][0]);
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
		showEditModal(user, index) {
			let obj = {
				id: user.id,
				full_name: user.full_name, 
				email: user.email, 
				role_id: user.role_id, 
			}
			this.editData = obj
			this.editModal = true
			this.index = index
		},  
		showDeleteModal(user, index) {
			const deleteModalObj = {
				showDeleteModal: true, 
				deleteUrl: 'app/delete_user', 
				data: user, 
				deleteIndex: index, 
				isDeleted: false,
			}
			this.$store.commit('setDeletingModal', deleteModalObj)

			// this.deleteItem = user
			// this.deleteIndex = index
			// this.deleteModal = true
		},
		closeModal() {
			this.addModal = false
			this.editModal = false
			this.data.full_name = ''
            this.data.email = ''
            this.data.password = ''
            this.data.role_id = null
		}
	},
	async created() {
		const [res, resrole] = await Promise.all([
			this.callApi('get', 'app/get_users'), 
			this.callApi('get', 'app/get_roles')
		])
		
		if(res.status === 200) {
			this.users =res.data
		} else {
			this.swr();
		}

		if(resrole.status === 200) {
			this.roles =resrole.data
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
				this.users.splice(obj.deleteIndex, 1)
			}
		}
	}
}
</script>