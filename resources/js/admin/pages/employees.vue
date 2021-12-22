<template>
	<div>
		<div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Employees <Button @click="addModal = true"><Icon type="md-add" /> Add Employees</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>Id</th>
								<th>Nik</th>
								<th>Name</th>
								<th>Gender</th>
								<th>Departement</th>
								<th>Position</th>
								<th>Action</th>
							</tr>
							<tr v-for="(employee, i) in listData" :key="i" v-if="listData.length">
								<td>{{ employee.id }}</td>
								<td class="_table_name">{{ employee.nik }}</td>
								<td>{{ employee.first_name +' '+ employee.last_name }}</td>
								<td>{{ employee.gender }}</td>
								<td>{{ employee.departement.name }}</td>
								<td>{{ employee.position.name }}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(employee, i)">Edit</Button>
									<!-- <Button type="error" size="small" @click="showDeleteModal(employee, i)" :loading="employee.isDeleting">Delete</Button> -->
								</td>
							</tr>
						</table>
					</div>
				</div>

				<!-- Tag adding modal -->
				<Modal
					v-model="addModal"
					title="Add Employee"
					:mask-closable = "false"
					:closable = "false">

                    <div class="space">
                        <label>NIK</label>
                        <Input type="text" v-model="data.nik" placeholder="Add NIK..." />
                    </div>
                    <div class="space">
                        <label>First Name</label>
                        <Input type="text" v-model="data.first_name" placeholder="Add First Name..." />
                    </div>
                    <div class="space">
                        <label>Last Name</label>
                        <Input type="text" v-model="data.last_name" placeholder="Add Last Name..." />
                    </div>
                    <div class="space">
                        <label>Born Place</label>
                        <Input type="text" v-model="data.born_place" placeholder="Add Born Place..." />
                    </div>
                    <div class="space">
                        <label>Bord Date</label><br>
                        <DatePicker type="date" placeholder="Select date" v-model="data.born_date"></DatePicker>
                    </div>
                    <div class="space">
                        <label>Gender</label>
					    <Select v-model="data.gender" placeholder="Select gender">
                            <Option :value="g.id" v-for="(g, i) in genders" :key="i" v-if="genders.length">{{ g.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <label>Religion</label>
					    <Select v-model="data.religion" placeholder="Select religion">
                            <Option :value="r.id" v-for="(r, i) in religions" :key="i" v-if="religions.length">{{ r.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <label>Phone</label>
                        <Input type="text" v-model="data.phone" placeholder="Add phone..." />
                    </div>
                    <div class="space">
                        <label>Email</label>
                        <Input type="email" v-model="data.email" placeholder="Add email..." />
                    </div>
                    <div class="space">
                        <label>Begin Work</label><br>
                        <DatePicker type="date" placeholder="Select date" v-model="data.in_date"></DatePicker>
                    </div>
                    <div class="space">
                        <label>End Work</label><br>
                        <DatePicker type="date" placeholder="Select date" v-model="data.out_date"></DatePicker>
                    </div>
                    <div class="space">
                        <label>Departement</label>
					    <Select v-model="data.departement_id" placeholder="Select department">
                            <Option :value="d.id" v-for="(d, i) in departements" :key="i" v-if="departements.length">{{ d.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <label>Position</label>
					    <Select v-model="data.position_id" placeholder="Select position">
                            <Option :value="p.id" v-for="(p, i) in positions" :key="i" v-if="positions.length">{{ p.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <label>Status</label><br>
                        <RadioGroup v-model="data.status">
                            <Radio :label="1">Active</Radio>
                            <Radio :label="2">Inactive</Radio>
                        </RadioGroup>
                    </div>

					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="addAction" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Add Employee'}}</Button>
					</div>
				</Modal>

				<!-- Tag editing modal -->
				<Modal
					v-model="editModal"
					title="Edit Employee"
					:mask-closable = "false"
					:closable = "false">

					<div class="space">
                        <label>NIK</label>
                        <Input type="text" v-model="editData.nik" placeholder="Add NIK..." />
                    </div>
                    <div class="space">
                        <label>First Name</label>
                        <Input type="text" v-model="editData.first_name" placeholder="Add First Name..." />
                    </div>
                    <div class="space">
                        <label>Last Name</label>
                        <Input type="text" v-model="editData.last_name" placeholder="Add Last Name..." />
                    </div>
                    <div class="space">
                        <label>Born Place</label>
                        <Input type="text" v-model="editData.born_place" placeholder="Add Born Place..." />
                    </div>
                    <div class="space">
                        <label>Bord Date</label><br>
                        <DatePicker type="date" placeholder="Select date" v-model="editData.born_date"></DatePicker>
                    </div>
                    <div class="space">
                        <label>Gender</label>
					    <Select v-model="editData.gender" placeholder="Select gender">
                            <Option :value="g.id" v-for="(g, i) in genders" :key="i" v-if="genders.length">{{ g.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <label>Religion</label>
					    <Select v-model="editData.religion" placeholder="Select religion">
                            <Option :value="r.id" v-for="(r, i) in religions" :key="i" v-if="religions.length">{{ r.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <label>Phone</label>
                        <Input type="text" v-model="editData.phone" placeholder="Add phone..." />
                    </div>
                    <div class="space">
                        <label>Email</label>
                        <Input type="email" v-model="editData.email" placeholder="Add email..." />
                    </div>
                    <div class="space">
                        <label>Begin Work</label><br>
                        <DatePicker type="date" placeholder="Select date" v-model="editData.in_date"></DatePicker>
                    </div>
                    <div class="space">
                        <label>End Work</label><br>
                        <DatePicker type="date" placeholder="Select date" v-model="editData.out_date"></DatePicker>
                    </div>
                    <div class="space">
                        <label>Departement</label>
					    <Select v-model="editData.departement_id" placeholder="Select department">
                            <Option :value="d.id" v-for="(d, i) in departements" :key="i" v-if="departements.length">{{ d.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <label>Position</label>
					    <Select v-model="editData.position_id" placeholder="Select position">
                            <Option :value="p.id" v-for="(p, i) in positions" :key="i" v-if="positions.length">{{ p.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <label>Status</label><br>
                        <RadioGroup v-model="editData.status">
                            <Radio :label="1">Active</Radio>
                            <Radio :label="2">Inactive</Radio>
                        </RadioGroup>
                    </div>
                    
					<div slot="footer">
						<Button type="default" @click="closeModal">Close</Button>
						<Button type="primary" @click="editAction" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding' : 'Edit Employee'}}</Button>
					</div>
				</Modal>

				<!-- Employee delete modal -->
				<!-- <Modal v-model="deleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure want to delete this Employee?</p>
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
				nik: '', 
                first_name: '', 
                last_name: '', 
                born_place: '', 
                born_date: '', 
                gender: 1, 
                religion: 1, 
                phone: '', 
                email: '', 
                in_date: '', 
                end_date: '', 
                departement_id: '', 
                position_id: '', 
                status: 1, 
			}, 
			editData: {
				nik: '', 
                first_name: '', 
                last_name: '', 
                born_place: '', 
                born_date: '', 
                gender: 1, 
                religion: 1, 
                phone: '', 
                email: '', 
                in_date: '', 
                end_date: '', 
                departement_id: '', 
                position_id: '', 
                status: 1, 
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
            genders: [
                {id: 1, name: "Male"}, 
                {id: 2, name: "Female"}, 
            ], 
            religions: [
                {id: 1, name: "Islam"}, 
                {id: 2, name: "Kristen"}, 
                {id: 3, name: "Hindu"}, 
                {id: 4, name: "Bhuda"}, 
                {id: 5, name: "Other"}, 
            ], 
            departements: [], 
            positions: [], 
		}
	}, 
	methods: {
		async addAction() {
			const res = await this.callApi('post', 'app/create_employee', this.data)
			if(res.status === 201) {
				this.listData.unshift(res.data)
				this.success('Employee has been added successfully!')
				this.addModal = false
				this.data.nik = ''
                this.data.first_name = ''
                this.data.last_name = ''
                this.data.born_place = ''
                this.data.born_date = ''
                this.data.gender = 1
                this.data.religion = 1
                this.data.phone = ''
                this.data.email = ''
                this.data.in_date = ''
                this.data.end_date = ''
                this.data.departement_id = ''
                this.data.position_id = ''
                this.data.status = ''
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
			const res = await this.callApi('post', 'app/edit_employee', this.editData)
			if(res.status === 201) {
				this.listData[this.index].nik = this.editData.nik
				this.listData[this.index].first_name = this.editData.first_name
				this.success('Employee has been edited successfully!')
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
				nik: objData.nik, 
                first_name: objData.first_name, 
                last_name: objData.last_name, 
                born_place: objData.born_place, 
                born_date: objData.born_date, 
                gender: objData.gender, 
                religion: objData.religion, 
                phone: objData.phone, 
                email: objData.email, 
                in_date: objData.in_date, 
                end_date: objData.end_date, 
                departement_id: objData.departement_id, 
                position_id: objData.position_id, 
                status: objData.status, 
			}
			this.editData = obj
			this.editModal = true
			this.index = index
		},  
		showDeleteModal(objData, index) {
			const deleteModalObj = {
				showDeleteModal: true, 
				deleteUrl: 'app/delete_employee', 
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
			this.data.nik = ''
            this.data.first_name = ''
            this.data.last_name = ''
            this.data.born_place = ''
            this.data.born_date = ''
            this.data.gender = 1
            this.data.religion = 1
            this.data.phone = ''
            this.data.email = ''
            this.data.in_date = ''
            this.data.end_date = ''
            this.data.departement_id = ''
            this.data.position_id = ''
            this.data.status = ''
		}
	},
	async created() {
        const [res, resdep, respos] = await Promise.all([
            this.callApi('get', 'app/get_employees'),
			this.callApi('get', 'app/get_departements'), 
			this.callApi('get', 'app/get_positions')
		])
		
		if(res.status === 200) {
			this.listData = res.data
		} else {
			this.swr();
		}

		if(resdep.status === 200) {
			this.departements = resdep.data
		} else {
			this.swr();
		}

        if(respos.status === 200) {
			this.positions = respos.data
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