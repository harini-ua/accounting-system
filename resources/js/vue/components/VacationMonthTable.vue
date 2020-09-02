<template>
    <div>
        <table class="table table-sm responsive-table highlight bordered no-footer" role="grid">
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
                    <td v-html="item.payment===paid ? item.name : ''"></td>
                    <td @click="onCell">{{ item.payment===paid ? item.start_date : '' }}</td>
                    <td>{{ item.payment }}</td>
                    <td>{{ item.payment===paid ? item.available_vacations : '' }}</td>
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
        <paginate
            :pageCount="Math.ceil(total/length)"
            :clickHandler="paginateHandler"
            :prevText="'Prev'"
            :nextText="'Next'"
            :containerClass="'pagination float-right'"
            :page-class="'waves-effect'"
        >
        </paginate>
    </div>
</template>

<script>
import Paginate from 'vuejs-paginate'
import {mapActions, mapGetters} from 'vuex'

export default {
    name: "VacationMonthTable",
    components: {Paginate},
    props: ['year', 'month', 'paid', 'days'],
    data() {
        return {
            draw: 1,
            length: 20,
        }
    },
    created() {
        this.fetchItems();
    },
    methods: {
        ...mapActions([
            'fetchVacations',
            'setVacation',
            'deleteVacation'
        ]),
        fetchItems() {
            this.fetchVacations({
                year: this.year,
                month: this.month,
                params: {
                    draw: this.draw,
                    start: this.length*(this.draw-1),
                    length: this.length,
                }
            });
        },
        onCell(item, day) {
            if (this.isFill) {
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
        paginateHandler(page) {
            this.draw = page;
            this.fetchItems();
        },
        totalDays(item) {
            return this.days.reduce((total, next) => {
                return total + (this.dayValue(item[next.day]) ? 1 : 0);
            }, 0);
        },
        cellClass(item, day) {
            if (item[day.day] === 'long_vacation') {
                return 'long-vacation-color';
            }
            if (day.holiday) {
                return 'light-red';
            }
            if (item[day.day] === 'actual') {
                return 'green';
            } else if (item[day.day] === 'sick') {
                return 'blue'
            } else if (item[day.day] === 'planned') {
                return 'yellow'
            }
        },
        dayValue(dayType) {
            if (dayType === 'actual' || dayType === 'sick') {
                return 1;
            }
            return '';
        }
    },
    computed: {
        ...mapGetters({
            items: 'allVacations',
            total: 'totalVacations',
            fillType: 'getFillType'
        }),
        isFill() {
            return !!this.fillType;
        }
    }
}
</script>

<style scoped>
    .light-red {
        background-color: #ffe6e6;
    }
    .long-vacation-color {
        background-color: #e7feff;
    }
</style>
