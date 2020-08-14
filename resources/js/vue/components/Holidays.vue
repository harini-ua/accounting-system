<template>
    <div class="holidays-component">
        <h6>Holidays</h6>
        <div class="responsive-table">
            <table>
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Date of the moved vacation</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(holiday, index) in holidays">
                    <td class="text-nowrap">
                        <date-input :is-edit="holiday.isEdit" v-model="holiday.date"></date-input>
                    </td>
                    <td>
                        <custom-input :is-edit="holiday.isEdit" v-model="holiday.name"></custom-input>
                    </td>
                    <td>
                        <date-input :is-edit="holiday.isEdit" v-model="holiday.moved_date"></date-input>
                    </td>
                    <td class="text-center">
                        <div>
                            <span class="cursor-pointer mr-2">
                                <i v-if="!holiday.isEdit" @click="editMode(index)" class="material-icons">edit</i>
                                <i v-if="holiday.isEdit" @click="save(index)" class="material-icons">save</i>
                            </span>
                            <span class="cursor-pointer" @click="deleteHoliday(holiday)"><i class="material-icons">delete</i></span>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="mt-5">
                <span class="btn waves-effect waves-light z-depth-4" @click="add">
                    <i class="material-icons">add</i>
                    <span class="hide-on-small-only">Add</span>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import {destroy, showError} from "../mixins";
import CustomInput from "./CustomInput";
import DateInput from "./DateInput";
import axios from 'axios';
import { mapActions } from 'vuex';

export default {
    components: {DateInput, CustomInput},
    props: ['data', 'storeUrl'],
    mixins: [showError, destroy],
    data() {
        return {
            holidays: this.data,
            isEdit: false,
        }
    },
    created() {
        this.holidays = this.holidays.map(holiday => {
            holiday.isEdit = false;
            return holiday;
        });
    },
    methods: {
        ...mapActions(['fetchMonths']),
        deleteHoliday: function(holiday) {
            if (holiday.id === 0) {
                this.holidays = this.holidays.filter(item => item.id !== holiday.id);
            } else {
                this.destroy(holiday.destroyLink, () => {
                    this.holidays = this.holidays.filter(item => item.id !== holiday.id);
                    this.fetchMonths();
                });
            }
        },
        editMode: function(index) {
            const holiday = this.holidays[index];
            holiday.isEdit = true;
            this.$set(this.holidays, index, holiday);
        },
        save: function(index) {
            let holiday = this.holidays[index];
            const method = holiday.id === 0 ? 'post' : 'put';
            const link = holiday.id === 0 ? this.storeUrl : holiday.updateLink;
            const data = {
                date: holiday.date,
                name: holiday.name,
                moved_date: holiday.moved_date
            }
            if (holiday.id === 0) {
                data.calendar_year_id = holiday.calendar_year_id;
            }

            axios({
                method: method,
                url: link,
                data: data
            })
                .then(resp => {
                    holiday = resp.data.holiday;
                    holiday.isEdit = false;
                    this.$set(this.holidays, index, holiday);
                    this.fetchMonths();
                })
                .catch((error) => this.showError(error));
        },
        add() {
            if (this.holidays[this.holidays.length - 1].id === 0) {
                return;
            }
            const holiday = Object.assign({}, this.holidays[0]);
            holiday.id = 0;
            holiday.date = null;
            holiday.name = null;
            holiday.moved_date = null;
            holiday.destroyLink = null;
            holiday.updateLink = null;
            holiday.isEdit = true;
            this.holidays.push(holiday);
        }
    }
}
</script>

<style scoped>

</style>
