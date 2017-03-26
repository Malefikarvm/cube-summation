<style>
    #box {
        height: 250px ;
        width: 100%;
    }
</style>
<template>
    <div class="code-box">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <textarea
                    :placeholder="placeHolder"
                    :value="value"

                    @input="onUpdate($event.target.value)"
                    @keydown.enter="submitCode"
                    @keydown.delete="scape"
                    id="box"
                >
                </textarea>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'code-box',

        props: {
            codeBoxValue: null,
            value: {
                type: [String, Number],
                required: false
            },
        },

        computed: {
            placeHolder: () => {
                return 'Escribe tu código aquí';
            }
        },

        methods: {
            submitCode: (e) => {
                var Vue = require('vue');
                Vue.use(require('vue-resource'));

                if (this.codeBoxValue) {
                    let codeVal = this.codeBoxValue.split(/\n/);
                    var lineCode = codeVal[codeVal.length - 1].trim();

                    var validateMatrixNumbers = (numbers, quantity) => {
                        var validate = {
                            valid: true,
                            nums: []
                        };

                        numbers = numbers.trim().split(' ');

                        if (numbers.length === quantity) {
                            numbers.map(num => {
                                if (!isNaN(parseInt(num))) {
                                    validate.valid = !validate.valid ? false : true;
                                    validate.nums.push(num);
                                } else {
                                    validate.valid = false;
                                }
                            });
                        } else {
                            validate.valid = false;
                        }

                        return validate;
                    }

                    var testCases = validateMatrixNumbers(lineCode.substring(0, 1), 1);
                    var intitializeMatrix = validateMatrixNumbers(lineCode.substring(0, 3), 2);

                    if (lineCode.substring(0, 6) === "UPDATE") {
                        var validate = validateMatrixNumbers(lineCode.substring(7, 14), 4);
                        if (validate.valid) {
                            Vue.http.post('/update', validate.nums)then(resp => {
                                if (resp) {
                                    e.target.value = this.codeBoxValue + '\n' + resp;
                                }
                            });
                        } else {
                            e.target.value = this.codeBoxValue + '\nOrden no encontrada';
                        }
                    } else if (lineCode.substring(0, 5) === "QUERY") {
                        var validate = validateMatrixNumbers(lineCode.substring(6, 17), 6);
                        if (validate.valid) {
                            Vue.http.post('/quey', validate.nums).then(resp => {
                                if (resp.sum) {
                                    e.target.value = this.codeBoxValue + '\n' + resp.sum;
                                } else {
                                    e.target.value = this.codeBoxValue + '\n' + resp;
                                }
                            });
                        } else {
                            e.target.value = this.codeBoxValue + '\nOrden no encontrada';
                        }
                    } else if (lineCode.substring(0, 5) === "CLEAR") {
                        e.target.value = '';
                        e.preventDefault();
                    } else if (intitializeMatrix.valid) {
                        console.log(intitializeMatrix.nums);
                        Vue.http.post('/intitialize-matrix', {
                            size: intitializeMatrix.nums[0],
                            operations: intitializeMatrix.nums[1]
                        });
                    } else if (testCases.valid) {
                        Vue.http.post('/set-test-cases', {testCases: testCases.nums});
                    } else {
                        e.target.value = this.codeBoxValue + '\nOrden no encontrada';
                    }
                }
            },

            scape: (e) => {
                var val = this.codeBoxValue;
                if (val.charAt(val.length - 1) === '\n')
                    e.preventDefault();
            },

            onUpdate: (value) => {
                this.codeBoxValue = value;
            }
        }
    }
</script>
