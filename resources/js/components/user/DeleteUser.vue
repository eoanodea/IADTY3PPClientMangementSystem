<template>
    <div>
        <!-- Modal Button -->
        <button 
            class="bx--btn bx--btn--lg bx--btn--danger" 
            type="button" 
            data-modal-target="#modal-ptxyfo5520i"
            @click="showDialog = true">
                Delete Client
        </button>

        <!-- Modal -->
        <cv-modal
                kind="danger"
                :visible="showDialog"
                @modal-shown="showDialog = true"
                @modal-hidden="showDialog = false"
                @modal-hide-request="showDialog = false"
                @secondary-click="actionSecondary"
                @primary-click="actionPrimary"
            >
            <template slot="title"><span class="warning">{{!disabled ? 'WARNING' : 'ERROR'}}</span></template>
            <template slot="content">
                <p v-if="!disabled">Are you sure you want to delete this <span class="logoCol">Client</span>?</p>
                <p v-else>You cannot delete this <span class="logoCol">Client</span> due to their Active <span class="logoCol">Project/s</span>.</p>
            </template>

            <!-- Buttons -->
            <template slot="secondary-button">{{!disabled ? "No" : "Back"}}</template>
            <template slot="primary-button" v-if="!disabled">Yes</template>
        </cv-modal>
    </div>
</template>
<script>
    import Vue from 'vue'
    import axios from 'axios'
    import router from './../../router'
    

    export default {
        props: ['id', 'disabled'],
        data() {
            return {
                showDialog: false,
                submitting: false
            }
        },
        methods: {
            actionPrimary() {
                let {submitting, showDialog} = this
                submitting = true
                this.$store.dispatch('user/deleteUser', this.id)
                .then(function(response) {
                    showDialog = false
                    submitting = false
                    router.push({
                        path: `/admin/users`
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
<style>
    .bx--body--with-modal-open {
        overflow: auto;
    }
</style>
