<template>
    <div id="table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="table_length">
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="table_filter" class="dataTables_filter">
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12">
                <table id="table" class="display table table-striped table-hover dataTable" role="grid"
                    aria-describedby="table_info">
                    <thead>
                        <tr role="row" class="text-capitalize">

                            <th v-for="(label, index) in head_labels" @click="changeOrderCollumn(index)" class="sorting"
                                tabindex="0" aria-controls="table" rowspan="1" colspan="1">{{ label }}</th>

                            <th rowspan="1" colspan="1" style="width: 100px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in getList" role="row" class="@if (($key%2)==1) odd @else even @endif">

                            <td v-for="item in row.items" class="sorting_1">
                                {{ renderItem(item) }}
                            </td>

                            <td>

                                <div v-for="action in row.actions" style="display: inline;">
                                    <form v-if="action.type == 'delete'" method="POST" :action="action.route" novalidate
                                        style="all: unset;">
                                        <input type="hidden" name="_token" :value="action.csrf">
                                        <input type="hidden" :name="action.delete_id_field_name"
                                            :value="action.delete_id">
                                        <a class="btn btn-link btn-round btn-danger">
                                            <button type="submit"><i class="fa fa-trash-alt"></i></button>
                                        </a>
                                    </form>
                                    <a v-else :href="action.route" :class="'btn btn-link btn-round ' + action.btnStyle">
                                        <i :class="action.icon"></i>
                                    </a>
                                </div>

                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['rows', 'head_labels'],
    data: () => {
        return {
            orderCollumn: 0,
            orderMode: 'asc',
            search: ''
        }
    },
    methods: {
        renderItem: (item) => {
            return item.type == 'image' ? '<img style="width: ' + item.imageSize + ';" src="' + item.imagePath + '"></img>' : item.label
        },
        changeOrderCollumn: function (newCollumnIndex) {
            this.orderCollumn = newCollumnIndex
        },
        changeOrderMode: function () {
            this.orderMode = this.orderMode != 'asc' ? 'asc' : 'desc'
        },
        sortFilteredRows: function(filteredRows) {
            filteredRows.sort((a, b) => {
                if (a.items[this.orderCollumn] > b.items[this.orderCollumn])
                    return this.orderMode == 'asc' ? -1 : 1
                if (a.items[this.orderCollumn] < b.items[this.orderCollumn])
                    return this.orderMode == 'asc' ? 1 : -1
                if (a.items[this.orderCollumn] == b.items[this.orderCollumn])
                    return 0
            })
        },
        filterRows() {
            let result = this.rows.filter((row, index) => {
                return this.searchHasFound(row)
            })

            return result
        },
        searchHasFound: function(row) {
            for (let i = 0; i < row.items.length; i++) {
                if (row.items[i]['label'].toLowerCase().indexOf(this.search.toLowerCase()) != -1)
                    return true
            }

            return false
        }
    },
    computed: {
        getList: function () {
            let filteredRows = this.filterRows()
            this.sortFilteredRows(filteredRows)

            return filteredRows
        }
    }
}
</script>