<template>
    <div v-show="isLoad">
        <div v-if="titleSuccess !== false" class="panel panel-default">
            <div class="panel-heading">{{titleSuccess}}</div>
        </div>
        <div v-else-if="gift === null" class="form-group">
            <button type="button" v-on:click="getGift"  class="btn btn-primary">Get gift</button>
        </div>
        <div v-else class="panel panel-default">
            <div class="panel-heading">Ваш подарунок:</div>
            <p>{{gift.title}}</p>
            <button type="button" v-on:click="actionGift"  class="btn btn-primary mb-3">{{gift.actionTitle}}</button>
            <button v-if="gift.isConvert" type="button" v-on:click="convertGift"  class="btn btn-primary mb-3">Конвертувати на рахунок лояльності</button>

            <button type="button" v-on:click="cancelGift"  class="btn btn-primary">Відмовитись від подарунку</button>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                gift: null,
                isLoad: false,
                titleSuccess: false,
            }
        },
        mounted() {
            var app = this;
            axios.get('/gift')
                .then(function (resp) {
                    app.gift = resp.data;
                    app.isLoad = true;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load gift");
                });
        },
        methods: {
            getGift() {
                var app = this;
                axios.get('/gift/create')
                    .then(function (resp) {
                        app.gift = resp.data;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не вдалося отримати подарунок");
                    });
            },
            cancelGift() {
                if (confirm("Ви впевнені що бажаєте відмовитись від подарунку?")) {
                    var app = this;
                    axios.get('/gift/cancel')
                        .then(function (resp) {
                            app.gift = null;
                        })
                        .catch(function (resp) {
                            alert("Не вдалося відмовитись від подарунку");
                        });
                }
            },
            convertGift() {
                var app = this;
                axios.get('/gift/convert')
                    .then(function (resp) {
                        app.titleSuccess = resp.data.titleSuccess;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не вдалося конвертувати подарунок");
                    });

            },
            actionGift() {
                var app = this;
                axios.get('/gift/action')
                    .then(function (resp) {
                        app.titleSuccess = resp.data.titleSuccess;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не вдалося виконати дію з подарунком");
                    });

            }
        }
    }
</script>
