<template>
	<div>
		<div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Departements <Button @click="addModal = true"><Icon type="md-add" /> Add Departement</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>Id</th>
								<th>Departement Name</th>
								<th>Created at</th>
								<th>Departement Status</th>
								<th>Action</th>
							</tr>
							<tr v-for="(departement, i) in listData" :key="i" v-if="listData.length">
								<td>{{ departement.id }}</td>
								<td class="_table_name">{{ departement.name }}</td>
								<td>{{ departement.created_at }}</td>
								<td>
                                    <span class="" v-if="departement.status == 1">Active</span>
                                    <span class="" v-else>Inactive</span>
                                </td>
								<td>
									<Button type="info" size="small" @click="showEditModal(departement, i)">Edit</Button>
									<!-- <Button type="error" size="small" @click="showDeleteModal(departement, i)" :loading="departement.isDeleting">Delete</Button> -->
								</td>
							</tr>
						</table>
					</div>
				</div>

				<!-- Tag adding modal -->
				<Modal
					v-model="addModal"
					title="Add Departement"
					:mask-closable = "false"
					:closable = "false">

                    <label>Departement Name</label>
					<Input v-model="data.name" placeholder="Add Departement name.." />
                    <div class="space"></div>

                    <label>Departement Status</label><br>
                    <RadioGroup v-model="data.status">
                        <Radio :label="1">Active</Radio>
                        <Radio :label="2">Inactive</Radio>
                    </RadioGroup>

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="addAction" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Add Departement'}}</Button>
					</div>
				</Modal>

				<!-- Tag editing modal -->
				<Modal
					v-model="editModal"
					title="Edit Departement"
					:mask-closable = "false"
					:closable = "false">

					<label>Departement Name</label>
					<Input v-model="editData.name" placeholder="Add Departement name.." />
                    <div class="space"></div>

                    <label>Departement Status</label><br>
                    <RadioGroup v-model="editData.status">
                        <Radio :label="1">Active</Radio>
                        <Radio :label="2">Inactive</Radio>
                    </RadioGroup>
					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="editAction" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Edit Departement'}}</Button>
					</div>
				</Modal>

				<!-- Departement delete modal -->
				<!-- <Modal v-model="deleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure want to delete this Departement?</p>
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
			if(this.data.name.trim() == '') return this.error('Departement name is required');
			if(!this.data.status) return this.error('Departement status is required');

			const res = await this.callApi('post', 'app/create_departement', this.data)
			if(res.status === 201) {
				this.listData.unshift(res.data)
				this.success('Departement has been added successfully!')
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
			if(this.editData.name.trim() == '') return this.error('Departement name is required');
            if(!this.data.status) return this.error('Departement status is required');

			const res = await this.callApi('post', 'app/edit_departement', this.editData)
			if(res.status === 201) {
				this.listData[this.index].name = this.editData.name
				this.success('Departement has been edited successfully!')
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
				deleteUrl: 'app/delete_departement', 
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
		const res = await this.callApi('get', 'app/get_departements')
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