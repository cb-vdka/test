<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb', ['title' => $config['seo']['class']['title']])
    <div class="col-md-12">
        <div class="card">
            <div class="card-body" style="padding: 0px !important;">
                @include('admin.subject_register.class.components.table')
            </div>
        </div>
    </div>
</div>
