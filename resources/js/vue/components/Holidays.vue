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
                                <i v-if="holiday.isEdit" @click="update(index)" class="material-icons">save</i>
                            </span>
                            <span class="cursor-pointer" @click="deleteHoliday(holiday)"><i class="material-icons">delete</i></span>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="mt-5">
                <a href="#" class="btn waves-effect waves-light z-depth-4">
                    <i class="material-icons">add</i>
                    <span class="hide-on-small-only">Add</span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import {destroy, showError} from "../mixins";
import CustomInput from "./CustomInput";
import DateInput from "./DateInput";
import axios from 'axios';

export default {
    components: {DateInput, CustomInput},
    props: ['data'],
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
        deleteHoliday: function(holiday) {
            this.destroy(holiday.destroyLink, () => this.holidays = this.holidays.filter(item => item.id !== holiday.id));
        },
        editMode: function(index) {
            const holiday = this.holidays[index];
            holiday.isEdit = true;
            this.$set(this.holidays, index, holiday);
        },
        update: function(index) {
            const holiday = this.holidays[index];
            axios.put(holiday.updateLink, {
                date: holiday.date,
                name: holiday.name,
                moved_date: holiday.moved_date,
            })
                .then(resp => {
                    holiday.isEdit = false;
                    this.$set(this.holidays, index, holiday);
                })
                .catch((error) => this.showError(error));
        },
    }
}
</script>

<style scoped>

</style>
