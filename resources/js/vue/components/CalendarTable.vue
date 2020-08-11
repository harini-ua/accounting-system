<template>
    <table class="calendar-table bordered">
        <thead>
        <tr>
            <th></th>
            <th>January</th>
            <th>February</th>
            <th>March</th>
            <th>I quarter</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center-align" colspan="5">Amount of days</td>
        </tr>
        <tr>
            <td>Calendar days</td>
            <td>31</td>
            <td>29</td>
            <td>31</td>
            <td class="font-weight-900">91</td>
        </tr>
        <tr>
            <td>Weekend</td>
            <td>8</td>
            <td>9</td>
            <td>9</td>
            <td class="font-weight-900">26</td>
        </tr>
        <tr>
            <td>Non-working days</td>
            <td>10</td>
            <td>9</td>
            <td>10</td>
            <td class="font-weight-900">29</td>
        </tr>
        <tr>
            <td>Working days</td>
            <td>21</td>
            <td>20</td>
            <td>21</td>
            <td class="font-weight-900">62</td>
        </tr>
        <tr>
            <td class="center-align" colspan="5">Working time</td>
        </tr>
        <tr>
            <td>40 hours week</td>
            <td>167</td>
            <td>160</td>
            <td>168</td>
            <td class="font-weight-900">495</td>
        </tr>
        <tr>
            <td>30 hours week</td>
            <td>126</td>
            <td>120</td>
            <td>126</td>
            <td class="font-weight-900">372</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {

}
</script>

<style>
    .calendar-table td {
        text-align: center;
    }
</style>
