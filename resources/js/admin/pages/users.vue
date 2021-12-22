<template>
	<div>
		<div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Users <Button @click="addModal = true"><Icon type="md-add" /> Add Users</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>Id</th>
								<th>Username</th>
								<th>Level</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
							<tr v-for="(user, i) in listData" :key="i" v-if="listData.length">
								<td>{{ user.id }}</td>
								<td class="_table_name">{{ user.username }}</td>
								<td>
                                    <span class="" v-if="user.level == 1">Active</span>
                                    <span class="" v-else>Inactive</span>
                                </td>
								<td>{{ user.created_at }}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(user, i)">Edit</Button>
									<!-- <Button type="error" size="small" @click="showDeleteModal(user, i)" :loading="user.isDeleting">Delete</Button> -->
								</td>
							</tr>
						</table>
					</div>
				</div>

				<!-- Tag adding modal -->
				<Modal
					v-model="addModal"
					title="Add User"
					:mask-closable = "false"
					:closable = "false">

                    <div class="space">
                        <label>Username</label>
                        <Input type="text" v-model="data.username" placeholder="Add username..." />
                    </div>
                    <div class="space">
                        <label>Level</label>
					    <Select v-model="data.level" placeholder="Select level user">
                            <Option :value="l.id" v-for="(l, i) in levels" :key="i" v-if="levels.length">{{ l.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <label>Password</label>
					    <Input type="password" v-model="data.password" placeholder="Add password..." />
                    </div>
                    <div class="space">
                        <label>Employee</label>
					    <Select v-model="data.employee_id" placeholder="Select employee">
                            <Option :value="e.id" v-for="(e, i) in employees" :key="i" v-if="employees.length">{{ e.first_name }}</Option>
                        </Select>
                    </div>

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="addAction" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Add User'}}</Button>
					</div>
				</Modal>

				<!-- Tag editing modal -->
				<Modal
					v-model="editModal"
					title="Edit User"
					:mask-closable = "false"
					:closable = "false">

					<div class="space">
                        <label>Username</label>
                        <Input type="text" v-model="editData.username" placeholder="Add username..." />
                    </div>
                    <div class="space">
                        <label>Level</label>
					    <Select v-model="editData.level" placeholder="Select level user">
                            <Option :value="l.id" v-for="(l, i) in levels" :key="i" v-if="levels.length">{{ l.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <label>Password</label>
					    <Input type="password" v-model="editData.password" placeholder="Add password..." />
                    </div>
                    <div class="space">
                        <label>Employee</label>
					    <Select v-model="editData.employee_id" placeholder="Select employee">
                            <Option :value="e.id" v-for="(e, i) in employees" :key="i" v-if="employees.length">{{ e.first_name }}</Option>
                        </Select>
                    </div>
                    
					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="editAction" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Edit User'}}</Button>
					</div>
				</Modal>

				<!-- User delete modal -->
				<!-- <Modal v-model="deleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure want to delete this User?</p>
					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteData">Delete</Button>
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
				username: '', 
                employee_id: '', 
                level: '', 
                password: ''
			}, 
			editData: {
				username: '', 
                employee_id: '', 
                level: '', 
                password: ''
			},
			addModal: false, 
			editModal: false, 
			deleteModal: false, 
			isAdding: false,
			listData: [], 
			index: -1, 
			deleteItem: {},
			deleteIndex: -1, 
			isDeleting: false,
            employees: [], 
            levels: [
                {id: 1, name: 'admin'}, 
                {id: 2, name: 'editor'}, 
                {id: 3, name: 'user'}, 
                {id: 4, name: 'moderator'}, 
            ]
		}
	}, 
	methods: {
		async addAction() {
			const res = await this.callApi('post', 'app/create_user', this.data)
			if(res.status === 201) {
				this.listData.unshift(res.data)
				this.success('User has been added successfully!')
				this.addModal = false
				this.data.username = ''
				this.data.employee_id = ''
				this.data.level = ''
				this.data.password = ''
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
		async editAction() {
			const res = await this.callApi('post', 'app/edit_user', this.editData)
			if(res.status === 201) {
				this.listData[this.index].username = this.editData.username
				this.success('User has been edited successfully!')
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
		showEditModal(objData, index) {
			let obj = {
				id: objData.id,
				username: objData.username, 
                employee_id: objData.employee_id, 
                level: objData.level, 
                password: objData.password, 
			}
			this.editData = obj
			this.editModal = true
			this.index = index
		},  
		showDeleteModal(objData, index) {
			const deleteModalObj = {
				showDeleteModal: true, 
				deleteUrl: 'app/delete_user', 
				data: objData, 
				deleteIndex: index, 
				isDeleted: false,
			}
			this.$store.commit('setDeletingModal', deleteModalObj)

			// this.deleteItem = objData
			// this.deleteIndex = index
			// this.deleteModal = true
		},
		closeModal() {
			this.addModal = false
			this.editModal = false
			this.data.username = ''
			this.data.employee_id = ''
			this.data.level = ''
			this.data.password = ''
		}
	},
	async created() {
		const [res, resemployee] = await Promise.all([
			this.callApi('get', 'app/get_users'), 
			this.callApi('get', 'app/get_employees')
		])
		
		if(res.status === 200) {
			this.listData = res.data
		} else {
			this.swr();
		}

		if(resemployee.status === 200) {
			this.employees = resemployee.data
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
				this.listData.splice(obj.deleteIndex, 1)
			}
		}
	}
}
</script>