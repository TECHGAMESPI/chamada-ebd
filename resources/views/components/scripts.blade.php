<script defer src="{{ asset('js/dataTables.js') }}"></script>
<script defer src="{{ asset('js/datatables-demo.js') }}"></script>
<script defer src="{{ asset('js/all.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->

<script src="{{ asset('app-assets/vendors/js/charts/chartist.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/charts/chartist-plugin-tooltip.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/charts/raphael-min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/charts/morris.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/timeline/horizontal-timeline.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('app-assets/js/core/app.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
<!-- END: Page JS-->
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#mytextarea', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists',
        menu: {
            file: {
                title: 'File',
                items: ''
            },
            edit: {
                title: 'Edit',
                items: 'undo redo | cut copy paste | selectall | searchreplace'
            },
            view: {
                title: 'View',
                items: ''
            },
            insert: {
                title: 'Insert',
                items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime'
            },
            format: {
                title: 'Format',
                items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align lineheight | forecolor backcolor | removeformat'
            },
            tools: {
                title: 'Tools',
                items: ''
            },
            table: {
                title: 'Table',
                items: 'inserttable | cell row column | tableprops deletetable'
            },
            help: {
                title: 'Help',
                items: 'help'
            }
        },
        language: 'pt_BR',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table'
        //toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });
</script>
