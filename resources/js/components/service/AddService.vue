<template>
    <loading-indicator v-if="submitting"/>
    <div class="bx--gridresponsive-form formAlignment" v-else>
        <!-- Message -->
        <div class="bx--row">
            <h3>Add <span class="logoCol">Service</span></h3>
        </div><br/>

        <!-- Title -->
        <div class="bx--row">
            <div class="bx--col-lg-12">
                <div class="bx--form-item bx--text-input-wrapper">
                    <label for="title" class="bx--label">Title</label>

                    <div class="bx--text-input__field-wrapper">
                        <input 
                        id="text-input-3" 
                        name="title" 
                        type="text" 
                        autocomplete="given-title" 
                        v-model="newService.title"
                        class="bx--text-input placeholderForms" 
                        placeholder="Name your Service">
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <br/>
        <div class="bx--row">
            <div class="bx--col-lg-12">
                <div class="bx--form-item bx--text-input-wrapper">
                        <label for="description" class="bx--label">Description</label>
                    <div class="bx--text-input__field-wrapper">
                        <textarea 
                            id="text-area-2" 
                            name="description" 
                            type="description" 
                            autocomplete="description" 
                            v-model="newService.description"
                            class="bx--text-area"
                            rows="4" 
                            cols="50" 
                            placeholder="Give your Service a description"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Standard Price -->
        <br/>
        <div class="bx--row">
            <div class="bx--col-lg-12">
                <div class="bx--form-item bx--text-input-wrapper">
                    <label for="standard_price" class="bx--label">Standard Price</label>
                    <div class="bx--text-input__field-wrapper">
                        <span class="price-prefix">€</span>
                        <input 
                        id="text-input-3" 
                        name="standard_price" 
                        type="number" 
                        autocomplete="given-standard_price" 
                        v-model="newService.standard_price"
                        class="bx--text-input placeholderForms price-input" 
                        placeholder="€Standard Price">
                    </div>
                </div>
            </div>
        </div>

        <!-- Recurring Payment Checkbox -->
        <br/>
        <div class="bx--row">
            <div class="bx--col-lg-12 checkbox-container">
                <cv-checkbox
                    name="recurring_payment" 
                    label="Recurring Payment"
                    value="recurring_payment"
                    v-model="newService.recurring_payment"
                    >
                </cv-checkbox>
            </div>
        </div>

        <!-- Recurring Payment Checkbox -->
        <br/>
        <div class="bx--row">
            <div class="bx--col-lg-12 checkbox-container">
                <cv-checkbox
                    name="is_public" 
                    label="Public Service"
                    value="is_public"
                    v-model="newService.is_public"
                    >
                </cv-checkbox>
            </div>
        </div>

        <!-- Button -->
        <br/>
        <div class="bx--row">
            <div class="bx--col-lg-12">
                <div class="bx--form-item">
                    <button 
                        class="bx--btn bx--btn--primary" 
                        type="submit"
                        @click="validateService"
                        :disabled="submitting">
                            Save
                    </button>
                </div>
            </div>
        </div>

        <!-- Error -->
        <data-error v-if="error" v-bind:error="error" />
        <br/>
        <div class="bx--row">
            <p v-if="errors.length">
            <b class="bx--form-requirement">Please correct the following error(s):</b>
                <ul>
                    <li v-for="error in errors" v-bind:key="error.id" class="bx--form-requirement">
                        {{ error.message }}
                    </li>
                </ul>
            </p>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Vue from 'vue';
    import router from './../../router'
    import DataError from './../table/DataError'
    
    import { mapGetters } from 'vuex';
    import LoadingIndicator from './../progress/LoadingIndicator'


    export default {
        data() {
            return {
                newService: {
                    title: '',
                    description: '',
                    recurring_payment: false,
                    standard_price: 0,
                    is_public: false
                },
                errors: [],
                submitting: false
            }
        },
        methods: {
            validateService: function() {
                const {newService} = this
                if(
                    newService.title &&
                    newService.description &&
                    newService.recurring_payment &&
                    newService.standard_price &&
                    newService.is_public) {
                    this.submitService()
                }

                this.errors = [];
                if(!newService.title) {
                    this.errors.push({
                        id: 0, 
                        message: 'Title required.'
                        });
                }
                if(!newService.description) {
                    this.errors.push({
                        id: 1, message: 'Description required.'
                        });
                }
                if(!newService.recurring_payment) {
                    this.errors.push({
                        id: 2, message: 'Input required.'
                        });
                }
                if(!newService.standard_price) {
                    this.errors.push({
                        id: 3, message: 'Standard Price required.'
                        });
                }
                if(!newService.is_public) {
                    this.errors.push({
                        id: 4, message: 'Input required.'
                        });
                }
            },
            submitService: function() {
                let {submitting} = this
                submitting = true
                this.$store.dispatch('service/addService', this.service)
                .then(function(response) {
                    console.log('submit respons', response)
                    submitting = false
                    if(response) {
                        router.push({
                            path: `/admin/services/show/${response}`
                        })
                    }
                }).catch(function(error) {
                    console.log('error', error)
                    submitting = false
                })
            }
        },
        components: {
            DataError,
            LoadingIndicator
        },
        computed: {
            ...mapGetters({
                error: 'service/error',
            })
        }
    }
</script>
