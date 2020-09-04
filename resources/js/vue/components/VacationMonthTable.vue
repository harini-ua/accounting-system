<template>
    <div class="dataTables_wrapper no-footer">
        <div class="dataTables_filter">
            <label>Search:<input v-model="search" type="search"></label>
        </div>
        <table class="table table-small responsive-table highlight bordered no-footer" role="grid">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>Payment</th>
                    <th>Available in total</th>
                    <th v-for="(day, index) in days" :key="index">{{ day.name }}</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in items" :key="index">
                    <td v-html="item.payment===paid ? item.name : ''" class="text-nowrap"></td>
                    <td class="text-nowrap">{{ item.payment===paid ? item.start_date : '' }}</td>
                    <td>{{ item.payment }}</td>
                    <td>
                        <span>{{ item.payment===paid ? Math.round(item.available_vacations) : '' }}</span>
                        <add-available-total
                            v-if="item.payment===paid"
                            v-on:update="updateTotalAvailable(item, 'available_vacations', $event)"
                        ></add-available-total>
                    </td>
                    <td
                        v-for="(day, index) in days"
                        :key="index"
                        :class="cellClass(item, day)"
                        :title="day.holiday ? day.tooltip : ''"
                        @click="onCell(item, day)"
                    >{{ dayValue(item[day.day]) }}</td>
                    <td>{{ totalDays(item) }}</td>
                </tr>
            </tbody>
        </table>
        <div class="dataTables_info">
            Showing {{ (draw-1)*length/2+1 }} to {{ draw*length < total ? draw*length/2 : total/2 }} of {{ total/2 }} entries
        </div>
        <paginate
            :pageCount="Math.ceil(total/length)"
            :clickHandler="paginateHandler"
            :prevText="'Prev'"
            :nextText="'Next'"
            :containerClass="'pagination dataTables_paginate paging_simple_numbers'"
            :page-class="'waves-effect'"
        >
        </paginate>
    </div>
</template>

<script>
import AddAvailableTotal from "./AddAvailableTotal";
import Paginate from 'vuejs-paginate'
import {mapActions, mapGetters, mapMutations} from 'vuex'

export default {
    name: "VacationMonthTable",
    components: {Paginate, AddAvailableTotal},
    props: ['year', 'month', 'paid', 'days', 'dayTypes'],
    data() {
        return {
            search: ''
        }
    },
    watch: {
        search(value) {
            this.setSearch(value);
            this.fetchVacations();
        }
    },
    created() {
        this.setYear(this.year);
        this.setMonth(this.month);
        this.fetchVacations();
    },
    methods: {
        ...mapActions([
            'fetchVacations',
            'setVacation',
            'deleteVacation',
            'setAvailableVacations'
        ]),
        ...mapMutations([
            'setPage',
            'setYear',
            'setMonth',
            'setSearch',
        ]),
        onCell(item, day) {
            if (this.isDayAvailable(item, day) && this.isFill) {
                if (this.fillType === 'weekday') {
                    this.deleteVacation({
                        item: item,
                        day: day
                    });
                } else {
                    this.setVacation({
                        item: item,
                        day: day
                    });
                }
            }
        },
        isDayAvailable(item, day)
        {
            return this.dayTypes[item[day.day]].available;
        },
        paginateHandler(page) {
            this.setPage(page);
            this.fetchVacations();
        },
        totalDays(item) {
            return this.days.reduce((total, next) => {
                return total + (this.dayValue(item[next.day]) ? 1 : 0);
            }, 0);
        },
        cellClass(item, day) {
            return this.dayTypes[item[day.day]].color;
        },
        dayValue(dayType) {
            return this.dayTypes[dayType].value;
        },
        updateTotalAvailable(item, field, value) {
            this.setAvailableVacations({
                item: item,
                available_vacations: value
            });
        }
    },
    computed: {
        ...mapGetters({
            items: 'allVacations',
            total: 'totalVacations',
            fillType: 'getFillType',
            draw: 'getPage',
            length: 'getLength',
        }),
        isFill() {
            return !!this.fillType;
        }
    }
}
</script>

<style scoped>
    .not-started-color {
        background-color: #f5f2ff;
    }
    .quited-color {
        background-color: #eeeeee;
    }
    .light-red {
        background-color: #ffe6e6;
    }
    .long-vacation-color {
        background-color: #e7feff;
    }
</style>
