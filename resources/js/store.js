import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        counter: 1000, 
        deleteModalObj: {
            showDeleteModal: false, 
            deleteUrl: '', 
            data: null, 
            deleteIndex: -1, 
            isDeleted: false,
        }
    }, 
    getters: {
        // getCounter(state) {
        //     if(state.counter > 1000) return 'oh my god, this is big...'
        //     return 'okay this is small ['+ state.counter +']'
        // }, 
        // getCounterByHalf(state) {
        //     return state.counter / 2
        // },
        getCounter(state) {
            return state.counter
        }, 
        getDeleteModalObj(state) {
            return state.deleteModalObj
        }
    }, 
    mutations: {
        changeTheCounter (state, data) {
            state.counter += data
        }, 
        setDeleteModal(state, data) {
            const deleteModalObj = {
                showDeleteModal: false, 
                deleteUrl: '', 
                data: null, 
                deleteIndex: -1, 
                isDeleted: data,
			}

            state.deleteModalObj = deleteModalObj
        }, 
        setDeletingModal(state, data) {
            state.deleteModalObj = data
        }
    }, 
    actions: {
        changeTheCounterAction ({commit}, data) {
            commit('changeTheCounter', data)
        }
    }
})