<template> 
<div>
    <!-- Modal Button -->
    <button
        class="bx--btn bx--btn--lg bx--btn--danger" 
        type="button" 
        data-modal-target="#modal-ptxyfo5520i"
        @click="showDialog = true">
            Delete Task
    </button>

    <!-- Modal -->
    <cv-modal
        kind="danger"
        :visible="showDialog"
        @modal-shown="showDialog = true"
        @modal-hidden="showDialog = false"
        @modal-hide-request="showDialog = false"
        @secondary-click="actionSecondary"
        @primary-click="actionPrimary">

        <template slot="title"><span class="warning">WARNING</span></template>
        <template slot="content"><p>Are you sure you want to delete this <span class="logoCol">Task</span>?</p></template>
    
        <!-- Buttons -->
        <template slot="secondary-button">No</template>
        <template slot="primary-button">Yes</template>
    </cv-modal>
</div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import router from './../../router'

    export default {
        props: ['id', 'isActive'],
        data() {
            return {
                showDialog: false,
                active: this.$route.params.active
                    ? (this.$route.params.active === 'true' ? true : false)
                    : this.isActive
            }
        },
        methods: {
            actionPrimary() {
                let {submitting, showDialog, isActive, id} = this
                submitting = true
                this.$store.dispatch('task/deleteTask', [id, isActive])
                .then(function(response) {
                    showDialog = false
                    submitting = false
                    const parent = isActive ? 'assignment' : 'services'
                    router.push({
                        path: `/admin/${parent}/show/${response.parentId}`
                    })
                }).catch(function(error) {
                    console.log('error', error)
                    submitting = false
                })
            },
            actionSecondary() {
                this.showDialog = false
            }
        },
        components: {
            //
        }
    }
</script>