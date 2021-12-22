<template>
	<div>
		<div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Positions <Button @click="addModal = true"><Icon type="md-add" /> Add Positions</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>Id</th>
								<th>Position Name</th>
								<th>Created at</th>
								<th>Position Status</th>
								<th>Action</th>
							</tr>
							<tr v-for="(position, i) in listData" :key="i" v-if="listData.length">
								<td>{{ position.id }}</td>
								<td class="_table_name">{{ position.name }}</td>
								<td>{{ position.created_at }}</td>
								<td>
                                    <span class="" v-if="position.status == 1">Active</span>
                                    <span class="" v-else>Inactive</span>
                                </td>
								<td>
									<Button type="info" size="small" @click="showEditModal(position, i)">Edit</Button>
									<!-- <Button type="error" size="small" @click="showDeleteModal(position, i)" :loading="position.isDeleting">Delete</Button> -->
								</td>
							</tr>
						</table>
					</div>
				</div>

				<!-- Tag adding modal -->
				<Modal
					v-model="addModal"
					title="Add Position"
					:mask-closable = "false"
					:closable = "false">

                    <label>Position Name</label>
					<Input v-model="data.name" placeholder="Add Position name.." />
                    <div class="space"></div>

                    <label>Position Status</label><br>
                    <RadioGroup v-model="data.status">
                        <Radio :label="1">Active</Radio>
                        <Radio :label="2">Inactive</Radio>
                    </RadioGroup>

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="addAction" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Add Position'}}</Button>
					</div>
				</Modal>

				<!-- Tag editing modal -->
				<Modal
					v-model="editModal"
					title="Edit Position"
					:mask-closable = "false"
					:closable = "false">

					<label>Position Name</label>
					<Input v-model="editData.name" placeholder="Add Position name.." />
                    <div class="space"></div>

                    <label>Position Status</label><br>
                    <RadioGroup v-model="editData.status">
                        <Radio :label="1">Active</Radio>
                        <Radio :label="2">Inactive</Radio>
                    </RadioGroup>
					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="editAction" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Edit Position'}}</Button>
					</div>
				</Modal>

				<!-- Position delete modal -->
				<!-- <Modal v-model="deleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure want to delete this Position?</p>
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
				name: '', 
                status: 1
			}, 
			editData: {
				name: '', 
                status: 1
			},
			addModal: false, 
			editModal: false, 
			deleteModal: false, 
			isAdding: false,
			listData: [], 
			index: -1, 
			deleteItem: {},
			deleteIndex: -1, 
			isDeleting: false
		}
	}, 
	methods: {
		async addAction() {
			if(this.data.name.trim() == '') return this.error('Position name is required');
			if(!this.data.status) return this.error('Position status is required');

			const res = await this.callApi('post', 'app/create_position', this.data)
			if(res.status === 201) {
				this.listData.unshift(res.data)
				this.success('Position has been added successfully!')
				this.addModal = false
				this.data.name = ''
			} else {
				if(res.status == 422) {
					if(res.data.errors.name) {
						this.error(res.data.errors.name[0]);
					}
				} else {
					this.swr();
				}
			}
		}, 
		async editAction() {
			if(this.editData.name.trim() == '') return this.error('Position name is required');
            if(!this.data.status) return this.error('Position status is required');

			const res = await this.callApi('post', 'app/edit_position', this.editData)
			if(res.status === 201) {
				this.listData[this.index].name = this.editData.name
				this.success('Position has been edited successfully!')
				this.editModal = false
			} else {
				if(res.status == 422) {
					if(res.data.errors) {
						if(res.data.errors.name) {
							this.error(res.data.errors.name[0]);
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
				name: objData.name, 
                status: objData.status
			}
			this.editData = obj
			this.editModal = true
			this.index = index
		},  
		showDeleteModal(objData, index) {
			const deleteModalObj = {
				showDeleteModal: true, 
				deleteUrl: 'app/delete_position', 
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
			this.data.name = ''
		}
	},
	async created() {
		const res = await this.callApi('get', 'app/get_positions')
		if(res.status === 200) {
			this.listData = res.data
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