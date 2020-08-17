<template>
    <div class="calendar-component responsive-table">
        <table class="calendar-table bordered">
            <thead>
            <tr>
                <th></th>
                <th v-for="month in months">{{ month.name }}</th>
                <th>{{ quarterName}}</th>
                <th v-if="halfYear">{{ halfYear == 'first' ? 'I' : 'II' }} half of year</th>
                <th v-if="year">{{ year }} year</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center-align" :colspan="colspanAmountOfDays">Amount of days</td>
            </tr>
            <tr>
                <td>Calendar days</td>
                <td v-for="month in months">
                    <editable-cell
                        v-bind:value.sync="month.calendar_days"
                        v-on:update="updateField(month, 'calendar_days', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(months, 'calendar_days') }}</td>
                <td v-if="halfYear" class="font-weight-900">{{ total(halfYearMonths(halfYear), 'calendar_days') }}</td>
                <td v-if="year" class="font-weight-900">{{ total(allMonths, 'calendar_days') }}</td>
            </tr>
            <tr>
                <td>Holidays</td>
                <td v-for="month in months">
                    <editable-cell
                        v-bind:value.sync="month.holidays"
                        v-on:update="updateField(month, 'holidays', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(months, 'holidays') }}</td>
                <td v-if="halfYear" class="font-weight-900">{{ total(halfYearMonths(halfYear), 'holidays') }}</td>
                <td v-if="year" class="font-weight-900">{{ total(allMonths, 'holidays') }}</td>
            </tr>
            <tr>
                <td>Weekends</td>
                <td v-for="month in months">
                    <editable-cell
                        v-bind:value.sync="month.weekends"
                        v-on:update="updateField(month, 'weekends', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(months, 'weekends') }}</td>
                <td v-if="halfYear" class="font-weight-900">{{ total(halfYearMonths(halfYear), 'weekends') }}</td>
                <td v-if="year" class="font-weight-900">{{ total(allMonths, 'weekends') }}</td>
            </tr>
            <tr>
                <td>Non-working days</td>
                <td v-for="month in months">{{ month.weekends + month.holidays }}</td>
                <td class="font-weight-900">{{ total(months, 'weekends', 'holidays') }}</td>
                <td v-if="halfYear" class="font-weight-900">{{ total(halfYearMonths(halfYear), 'weekends', 'holidays') }}</td>
                <td v-if="year" class="font-weight-900">{{ total(allMonths, 'weekends', 'holidays') }}</td>
            </tr>
            <tr>
                <td>Working days</td>
                <td v-for="month in months">{{ workingDays(month) }}</td>
                <td class="font-weight-900">{{ totalWorkingDays(months) }}</td>
                <td v-if="halfYear" class="font-weight-900">{{ totalWorkingDays(halfYearMonths(halfYear)) }}</td>
                <td v-if="year" class="font-weight-900">{{ totalWorkingDays(allMonths) }}</td>
            </tr>
            <tr>
                <td class="center-align" colspan="5">Working time (hours)</td>
            </tr>
            <tr>
                <td>40 hours week</td>
                <td v-for="month in months">{{ workingDays(month) * 8 }}</td>
                <td class="font-weight-900">{{ totalWorkingTime(months, 8)}}</td>
                <td v-if="halfYear" class="font-weight-900">{{ totalWorkingTime(halfYearMonths(halfYear), 8)}}</td>
                <td v-if="year" class="font-weight-900">{{ totalWorkingTime(allMonths, 8)}}</td>
            </tr>
            <tr>
                <td>30 hours week</td>
                <td v-for="month in months">{{ workingDays(month) * 6 }}</td>
                <td class="font-weight-900">{{ totalWorkingTime(months, 6)}}</td>
                <td v-if="halfYear" class="font-weight-900">{{ totalWorkingTime(halfYearMonths(halfYear), 6)}}</td>
                <td v-if="year" class="font-weight-900">{{ totalWorkingTime(allMonths, 6)}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

import EditableCell from "./EditableCell";
import axios from 'axios';
import { mapGetters } from 'vuex';
import { mapMutations } from 'vuex';
import { showError } from "../mixins";

export default {
    mixins: [ showError ],
    components: { EditableCell },
    props: ['quarter', 'quarterName', 'updateCellUrl', 'halfYear', 'year'],
    methods: {
        ...mapMutations(['setMonthField']),
        total: function(months, field1, field2) {
            return months.reduce((total, next) => {
                if (field2) {
                    return total + next[field1] + next[field2];
                }
                return total + next[field1];
            }, 0);
        },
        totalWorkingDays: function(months) {
            return months.reduce((total, next) => {
                return total + this.workingDays(next);
            }, 0);
        },
        workingDays: function(month) {
            return month.calendar_days - month.holidays - month.weekends;
        },
        totalWorkingTime: function(months, hours) {
            return months.reduce((total, next) => {
                return total + this.workingDays(next) * hours;
            }, 0);
        },
        updateField: function(month, field, value) {
            axios.put(this.updateCellUrl + '/' + month.id, {
                field: field,
                value: value,
            })
                .then(resp => this.setMonthField({
                    monthId: month.id,
                    field: field,
                    value: +value
                }))
                .catch((error) => this.showError(error))
        },
    },
    computed: {
        ...mapGetters(['quarterMonths', 'halfYearMonths', 'allMonths']),
        months: function()
        {
            return this.quarterMonths(this.quarter);
        },
        colspanAmountOfDays: function() {
            if (this.year) return 7;
            if (this.halfYear) return 6;
            return 5;
        },
    },
}
</script>

<style scoped>
    .calendar-table td {
        text-align: center;
    }
    .calendar-component {
        overflow-x: auto;
    }
</style>
