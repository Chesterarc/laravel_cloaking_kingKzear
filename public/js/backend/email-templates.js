(function () {

    FTX.EmailTemplate = {

        list: {

            selectors: {
                email_table: $('#email-templates-table'),
            },

            init: function () {

                this.selectors.email_table.dataTable({

                    processing: false,
                    serverSide: true,
                    ajax: {
                        url: this.selectors.email_table.data('ajax_url'),
                        type: 'post'
                    },
                    columns: [
                        { data: 'title', name: 'title' },
                        { data: 'content', name: 'content' },
                        { data: 'slug', name: 'slug' },
                        { data: 'status', name: 'status' },
                        { data: 'actions', name: 'actions', searchable: false, sortable: false }
                    ],
                    order: [[0, "asc"]],
                    searchDelay: 500,
                    "createdRow": function (row, data, dataIndex) {
                        FTX.Utils.dtAnchorToForm(row);
                    }
                });
            }
        },

        edit: {
            init: function (locale) {
                FTX.tinyMCE.init(locale);
            }
        },
    }
})();