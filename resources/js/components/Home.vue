<template>
    <div>
        <div class="d-flex justify-content-end">
            <input type="date" name="" class="form-control mb-3" style="width:10rem;" id="" v-model="datepick" @change="datePick()">
        </div>
        <div class="text-center" v-if="!calculation">
            <i class="fas fa-spinner fa-pulse fa-3x"></i>
        </div>
        <div class="row" v-if="calculation">
            <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                <div class="card">
                    <div class="card-header text-center">
                        <b>{{ day }} Sell</b>
                    </div>
                    <div class="p-3 d-flex justify-content-between align-items-center">
                        <div class="h3">
                            {{ calculation.total_sell }} ৳
                        </div>
                        <div>
                            <i class="fas fa-cart-plus fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                <div class="card">
                    <div class="card-header text-center">
                        <b>{{ day }} Income</b>
                    </div>
                    <div class="p-3 d-flex justify-content-between align-items-center">
                        <div class="h3">
                            {{ calculation.total_income }} ৳
                        </div>
                        <div>
                            <i class="fas fa-money-check-alt fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                <div class="card">
                    <div class="card-header text-center">
                        <b>{{ day }} Selling item</b>
                    </div>
                    <div class="p-3 d-flex justify-content-between align-items-center">
                        <div class="h3">
                            {{ calculation.total_item }} ৳
                        </div>
                        <div>
                            <i class="fas fa-box-open fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                <div class="card">
                    <div class="card-header text-center">
                        <b>{{ day }} Expense</b>
                    </div>
                    <div class="p-3 d-flex justify-content-between align-items-center">
                        <div class="h3">
                            {{ calculation.total_expense }} ৳
                        </div>
                        <div>
                            <i class="fas fa-hand-holding-usd fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-2">
            <div class="p-3" id="line_top_x"></div>
        </div>
    </div>
</template>

<script>
    export default {
         created() {
            if(!User.loggedIn()) {
                this.$router.push({name: '/'});
            }

            let date = new Date();
            this.collectCal(date);

            axios.get("/api/dashboard/monthdata")
                .then(res => {
                    var data = Object.values(res.data);
                    this.drawChart(data);
                    this.monthData = data;
                })
                .catch(error => this.errorMessage = error.response.data.message)

          
        },
        data() {
            return {
                calculation: null,
                datepick: null,
                monthData: null,
            }
        },
        methods: {
            datePick() {
                this.collectCal(this.datepick);
            },
            collectCal(date) {
                axios.post("/api/dashboard/calculation", {date: date})
                    .then(res => {
                        this.calculation = res.data;
                    })
                    .catch(error => this.errorMessage = error.response.data.message)
            },
            drawChart(datas) {
                google.charts.load('current', {'packages':['line']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = new google.visualization.DataTable();
                    data.addColumn('number', 'Day');
                    data.addColumn('number', 'Sells');
                    data.addColumn('number', 'Income');
                    data.addColumn('number', 'Expense');
                    data.addRows(datas);

                    var options = {
                        chart: {
                        title: 'This Month Shop Status',
                        subtitle: 'in taka (BDT)'
                        },
                        width: 100+'%',
                        height: 500,
                        axes: {
                        x: {
                            0: {side: 'top'}
                        }
                        },
                        colors: ['#1F3BB3', '#34B1AA', '#F95F53']
                    };

                    var chart = new google.charts.Line(document.getElementById('line_top_x'));

                    chart.draw(data, google.charts.Line.convertOptions(options));
                }
           }
        },
        computed: {
            day() {
                if(this.datepick) {  
                    return this.datepick
                } else {
                    return 'Today';
                }
            }
        }
    }
</script>