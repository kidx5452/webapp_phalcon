<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['partner.lbl_list'] }}
            </header>
            <div class="panel-body">
                <form method="get" action="" class="form-horizontal tasi-form form-inline">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="form" class="btn btn-success m-b-10">{{ labelkey['general.btn_addnew'] }}</a>
                        </div>
                        <div class="col-md-6 text-right">
                            <input type="text" name="q" class="form-control" placeholder="{{ labelkey['general.lbl_search'] }}..." value="{{ q }}" />
                            <select class="form-control" name="status">
                                <option value="2">{{ labelkey['general.lbl_status'] }}</option>
                                <option value="0" {{ _GET['status'] is defined AND _GET['status']==0?'selected':'' }}>{{ labelkey['general.lbl_hide'] }}</option>
                                <option value="1" {{ _GET['status'] is defined AND _GET['status']==1?'selected':'' }}>{{ labelkey['general.lbl_show'] }}</option>
                            </select>
                            <button class="btn btn-info" type="submit">{{ labelkey['general.lbl_search'] }}</button>
                        </div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ labelkey['partner.lbl_avatar'] }}</th>
                        <th>{{ labelkey['partner.lbl_name'] }}</th>
                        <th>{{ labelkey['partner.lbl_status'] }}</th>
                        <th>{{ labelkey['partner.lbl_action'] }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in listdata %}
                        <tr>
                            <td>{{ item.id }}</td>
                            <td><img src="{{ media.host~item.avatar }}" alt=""></td>
                            <td>{{ item.name }} <br> <a href="{{ item.link }}" target="_blank">{{ item.link }}</a></td>
                            <td><strong>{{ item.status==1?'<span class="label label-success">Show</span>':'<span class="label label-inverse">Hide</span>' }}</strong></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default" title="{{ labelkey['general.btn_edit'] }}" href="form?id={{ item.id }}"><i class="zmdi zmdi-edit"></i></a>
                                    <a class="btn btn-default" onclick="return confirm('Are you sure ?');" title="{{ labelkey['general.btn_delete'] }}" href="delete?id={{ item.id }}"><i class="zmdi zmdi-delete"></i></a>
                                </div>
                            </td>
                        </tr>
                    {% endfor %}

                    </tbody>
                </table>
                {% include "layouts/paging.volt" %}
            </div>
        </section>
    </div>
</div>