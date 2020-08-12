<template>
    <table class="calendar-table bordered">
        <thead>
        <tr>
            <th></th>
            <th v-for="month in months">{{ month.name }}</th>
            <th>{{ quarterName}}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center-align" colspan="5">Amount of days</td>
        </tr>
        <tr>
            <td>Calendar days</td>
            <td v-for="month in months" class="cursor-pointer">
                <editable-cell v-bind:value.sync="month.calendar_days" v-on:update="updateField(month, 'calendar_days', $event)"></editable-cell>
            </td>
            <td class="font-weight-900">{{ total('calendar_days') }}</td>
        </tr>
        <tr>
            <td>Holidays</td>
            <td v-for="month in months">{{ month.holidays }}</td>
            <td class="font-weight-900">{{ total('holidays') }}</td>
        </tr>
        <tr>
            <td>Weekends</td>
            <td v-for="month in months">{{ month.weekends }}</td>
            <td class="font-weight-900">{{ total('weekends') }}</td>
        </tr>
        <tr>
            <td>Non-working days</td>
            <td v-for="month in months">{{ month.weekends + month.holidays }}</td>
            <td class="font-weight-900">{{ total('weekends', 'holidays') }}</td>
        </tr>
        <tr>
            <td>Working days</td>
            <td v-for="month in months">{{ workingDays(month) }}</td>
            <td class="font-weight-900">{{ totalWorkingDays }}</td>
        </tr>
        <tr>
            <td class="center-align" colspan="5">Working time (hours)</td>
        </tr>
        <tr>
            <td>40 hours week</td>
            <td v-for="month in months">{{ workingDays(month) * 8 }}</td>
            <td class="font-weight-900">{{ totalWorkingTime(8)}}</td>
        </tr>
        <tr>
            <td>30 hours week</td>
            <td v-for="month in months">{{ workingDays(month) * 6 }}</td>
            <td class="font-weight-900">{{ totalWorkingTime(6)}}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>

import EditableCell from "./EditableCell";
import axios from 'axios';

export default {
    components: {EditableCell},
    props: ['data', 'quarterName'],
    data() {
        return {
            months: this.data
        }
    },
    methods: {
        total: function(field1, field2) {
            return this.months.reduce((total, next) => {
                if (field2) {
                    return total + next[field1] + next[field2];
                }
                return total + next[field1];
            }, 0);
        },
        workingDays: function(month) {
            return month.calendar_days - month.holidays - month.weekends;
        },
        totalWorkingTime: function(hours) {
            return this.months.reduce((total, next) => {
                return total + this.workingDays(next) * hours;
            }, 0);
        },
        updateField: function(month, field, value) {
            axios.put('/calendar/updateMonth/' + month.id, {
                field: field,
                value: value,
            })
                .then(resp => month[field] = +value)
                .catch(error => swal('Error!', error.message ? error.message: 'Something went wrong! Please, try again later.', 'error'));
        },
    },
    computed: {
        totalWorkingDays: function() {
            return this.months.reduce((total, next) => {
                return total + this.workingDays(next);
            }, 0);
        },
    },
}
</script>

<style>
    .calendar-table td {
        text-align: center;
    }
</style>
