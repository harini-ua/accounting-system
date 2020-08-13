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
                <tr v-for="holiday in holidays">
                    <td class="text-nowrap">{{ holiday.date }}</td>
                    <td>{{ holiday.name }}</td>
                    <td>{{ holiday.moved_date }}</td>
                    <td class="text-center">
                        <div>
                            <span class="cursor-pointer mr-2"><i class="material-icons">edit</i></span>
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

export default {
    props: ['data'],
    mixins: [showError, destroy],
    data() {
        return {
            holidays: this.data
        }
    },
    methods: {
        deleteHoliday: function(holiday) {
            this.destroy(holiday.deleteLink, () => this.holidays = this.holidays.filter(item => item.id !== holiday.id));
        }
    }
}
</script>

<style scoped>

</style>
