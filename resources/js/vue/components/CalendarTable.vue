<template>
    <div class="calendar-component responsive-table">
        <table class="calendar-table bordered">
            <thead>
            <tr>
                <th :rowspan="2" class="text-center">Title</th>
                <th :colspan="4">I quarter</th>
                <th :colspan="4">II quarter</th>
                <th :rowspan="2">I half of year</th>
                <th :colspan="4">III quarter</th>
                <th :colspan="4">IV quarter</th>
                <th :rowspan="2">II half of year</th>
                <th :rowspan="2">Year</th>
            </tr>
            <tr>
                <th v-for="month in quarterMonths('first')">{{ month.name.slice(0, 3) }}</th>
                <th>Total</th>
                <th v-for="month in quarterMonths('second')">{{ month.name.slice(0, 3) }}</th>
                <th>Total</th>
                <th v-for="month in quarterMonths('third')">{{ month.name.slice(0, 3) }}</th>
                <th>Total</th>
                <th v-for="month in quarterMonths('fourth')">{{ month.name.slice(0, 3) }}</th>
                <th>Total</th>
                <th v-if="halfYear">{{ halfYear == 'first' ? 'I' : 'II' }} half of year</th>
                <th v-if="year">{{ year }} year</th>
            </tr>
            </thead>
            <tbody>
           <tr>
                <td>Calendar days</td>
                <td v-for="month in quarterMonths('first')">
                    <editable-cell
                        v-bind:value.sync="month.calendar_days"
                        v-on:update="updateField(month, 'calendar_days', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('first'), 'calendar_days') }}</td>
                <td v-for="month in quarterMonths('second')">
                    <editable-cell
                        v-bind:value.sync="month.calendar_days"
                        v-on:update="updateField(month, 'calendar_days', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('second'), 'calendar_days') }}</td>
                <td class="font-weight-900">{{ total(halfYearMonths('first'), 'calendar_days') }}</td>
                <td v-for="month in quarterMonths('third')">
                    <editable-cell
                        v-bind:value.sync="month.calendar_days"
                        v-on:update="updateField(month, 'calendar_days', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('third'), 'calendar_days') }}</td>
                <td v-for="month in quarterMonths('fourth')">
                    <editable-cell
                        v-bind:value.sync="month.calendar_days"
                        v-on:update="updateField(month, 'calendar_days', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('fourth'), 'calendar_days') }}</td>
                <td class="font-weight-900">{{ total(halfYearMonths('second'), 'calendar_days') }}</td>
                <td class="font-weight-900">{{ total(allMonths, 'calendar_days') }}</td>
            </tr>
            <tr>
                <td>Holidays</td>
                <td v-for="month in quarterMonths('first')">
                    <editable-cell
                        v-bind:value.sync="month.holidays"
                        v-on:update="updateField(month, 'holidays', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('first'), 'holidays') }}</td>
                 <td v-for="month in quarterMonths('second')">
                    <editable-cell
                        v-bind:value.sync="month.holidays"
                        v-on:update="updateField(month, 'holidays', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('second'), 'holidays') }}</td>
                <td class="font-weight-900">{{ total(halfYearMonths('first'), 'holidays') }}</td>
                 <td v-for="month in quarterMonths('third')">
                    <editable-cell
                        v-bind:value.sync="month.holidays"
                        v-on:update="updateField(month, 'holidays', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('third'), 'holidays') }}</td>
                 <td v-for="month in quarterMonths('fourth')">
                    <editable-cell
                        v-bind:value.sync="month.holidays"
                        v-on:update="updateField(month, 'holidays', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('fourth'), 'holidays') }}</td>
                <td class="font-weight-900">{{ total(halfYearMonths('second'), 'holidays') }}</td>
                <td class="font-weight-900">{{ total(allMonths, 'holidays') }}</td>
            </tr>
            <tr>
                <td>Weekends</td>
                <td v-for="month in quarterMonths('first')">
                    <editable-cell
                        v-bind:value.sync="month.weekends"
                        v-on:update="updateField(month, 'weekends', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('first'), 'weekends') }}</td>
                <td v-for="month in quarterMonths('second')">
                    <editable-cell
                        v-bind:value.sync="month.weekends"
                        v-on:update="updateField(month, 'weekends', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('second'), 'weekends') }}</td>
                <td class="font-weight-900">{{ total(halfYearMonths('first'), 'weekends') }}</td>
                <td v-for="month in quarterMonths('third')">
                    <editable-cell
                        v-bind:value.sync="month.weekends"
                        v-on:update="updateField(month, 'weekends', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('third'), 'weekends') }}</td>
                <td v-for="month in quarterMonths('fourth')">
                    <editable-cell
                        v-bind:value.sync="month.weekends"
                        v-on:update="updateField(month, 'weekends', $event)"
                    ></editable-cell>
                </td>
                <td class="font-weight-900">{{ total(quarterMonths('fourth'), 'weekends') }}</td>
                <td class="font-weight-900">{{ total(halfYearMonths('second'), 'weekends') }}</td>
                <td class="font-weight-900">{{ total(allMonths, 'weekends') }}</td>
            </tr>
            <tr>
                <td>Non-working days</td>
                <td v-for="month in quarterMonths('first')">{{ month.weekends + month.holidays }}</td>
                <td class="font-weight-900">{{ total(quarterMonths('first'), 'weekends', 'holidays') }}</td>
                <td v-for="month in quarterMonths('second')">{{ month.weekends + month.holidays }}</td>
                <td class="font-weight-900">{{ total(quarterMonths('second'), 'weekends', 'holidays') }}</td>
                <td class="font-weight-900">{{ total(halfYearMonths('first'), 'weekends', 'holidays') }}</td>
                <td v-for="month in quarterMonths('third')">{{ month.weekends + month.holidays }}</td>
                <td class="font-weight-900">{{ total(quarterMonths('fourth'), 'weekends', 'holidays') }}</td>
                <td v-for="month in quarterMonths('third')">{{ month.weekends + month.holidays }}</td>
                <td class="font-weight-900">{{ total(quarterMonths('fourth'), 'weekends', 'holidays') }}</td>
                <td class="font-weight-900">{{ total(halfYearMonths('second'), 'weekends', 'holidays') }}</td>
                <td class="font-weight-900">{{ total(allMonths, 'weekends', 'holidays') }}</td>
            </tr>
            <tr>
                <td>Working days</td>
                <td v-for="month in quarterMonths('first')">{{ workingDays(month) }}</td>
                <td class="font-weight-900">{{ totalWorkingDays(quarterMonths('first')) }}</td>
                <td v-for="month in quarterMonths('second')">{{ workingDays(month) }}</td>
                <td class="font-weight-900">{{ totalWorkingDays(quarterMonths('second')) }}</td>
                <td class="font-weight-900">{{ totalWorkingDays(halfYearMonths('third')) }}</td>
                <td v-for="month in quarterMonths('third')">{{ workingDays(month) }}</td>
                <td class="font-weight-900">{{ totalWorkingDays(quarterMonths('third')) }}</td>
                <td v-for="month in quarterMonths('fourth')">{{ workingDays(month) }}</td>
                <td class="font-weight-900">{{ totalWorkingDays(quarterMonths('fourth')) }}</td>
                <td class="font-weight-900">{{ totalWorkingDays(halfYearMonths('second')) }}</td>
                <td class="font-weight-900">{{ totalWorkingDays(allMonths) }}</td>
            </tr>
            <tr>
                <td class="center-align" colspan="20">Working time (hours)</td>
            </tr>
            <tr>
                <td>40 hours week</td>
                <td v-for="month in quarterMonths('first')">{{ workingDays(month) * 8 }}</td>
                <td class="font-weight-900">{{ totalWorkingTime(quarterMonths('first'), 8)}}</td>
                <td v-for="month in quarterMonths('second')">{{ workingDays(month) * 8 }}</td>
                <td class="font-weight-900">{{ totalWorkingTime(quarterMonths('second'), 8)}}</td>
                <td class="font-weight-900">{{ totalWorkingTime(halfYearMonths('first'), 8)}}</td>
                <td v-for="month in quarterMonths('third')">{{ workingDays(month) * 8 }}</td>
                <td class="font-weight-900">{{ totalWorkingTime(quarterMonths('third'), 8)}}</td>
                <td v-for="month in quarterMonths('fourth')">{{ workingDays(month) * 8 }}</td>
                <td class="font-weight-900">{{ totalWorkingTime(quarterMonths('fourth'), 8)}}</td>
                <td class="font-weight-900">{{ totalWorkingTime(halfYearMonths('second'), 8)}}</td>
                <td class="font-weight-900">{{ totalWorkingTime(allMonths, 8)}}</td>
            </tr>
            <tr>
                <td>30 hours week</td>
                <td v-for="month in quarterMonths('first')">{{ workingDays(month) * 6 }}</td>
                <td class="font-weight-900">{{ totalWorkingTime(quarterMonths('first'), 6)}}</td>
                <td v-for="month in quarterMonths('second')">{{ workingDays(month) * 6 }}</td>
                <td class="font-weight-900">{{ totalWorkingTime(quarterMonths('second'), 6)}}</td>
                <td class="font-weight-900">{{ totalWorkingTime(halfYearMonths('first'), 6)}}</td>
                <td v-for="month in quarterMonths('third')">{{ workingDays(month) * 6 }}</td>
                <td class="font-weight-900">{{ totalWorkingTime(quarterMonths('third'), 6)}}</td>
                <td v-for="month in quarterMonths('fourth')">{{ workingDays(month) * 6 }}</td>
                <td class="font-weight-900">{{ totalWorkingTime(quarterMonths('fourth'), 6)}}</td>
                <td class="font-weight-900">{{ totalWorkingTime(halfYearMonths('second'), 6)}}</td>
                <td class="font-weight-900">{{ totalWorkingTime(allMonths, 6)}}</td>
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
        colspanAmountOfDays: function() {
            if (this.year) return 7;
            if (this.halfYear) return 6;
            return 5;
        },
    },
}
</script>

<style scoped lang="scss">
    .calendar-table {
        th, td {
            text-align: center;
            font-size: 14px;
            padding: 10px 5px !important;
        }
    }
    .calendar-component {
        overflow-x: auto;
    }
</style>
