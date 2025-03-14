<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;

return [
    // 页面标题
    'title' => '用户',

    // 模型单数，用作页面新建$single
    'single' => '用户',

    // 数据模型，用做数据的CRUD
    'model' => User::class,

    // 设置页面访问权限
    'permission' => function () {
        return Auth::user()->can('manage_users');
    },

    // 渲染数据表格
    'columns' => [
        'id',
        'avatar' => [
            'title' => '头像',
            'output' => function ($avatar, $model) {
                return empty($avatar) ? 'N/A' : '<img src="' . $avatar . '" width="40">';
            },
            'sortable' => false,
        ],
        'name' => [
            'title' => '用户名',
            'sortable' => false,
            'output' => function ($name, $model) {
                return '<a href="/users/' . $model->id . '" target="_blank">' . $name . '</a>';
            },
        ],
        'email' => [
            'title' => '邮箱',
        ],
        'operation' => [
            'title' => '管理',
            'sortable' => false,
        ],
    ],

    // 模型表单设置项
    'edit_fields' => [
        'name' => [
            'title' => '用户名'
        ],
        'email' => [
            'title' => '邮箱'
        ],
        'password' => [
            'title' => '密码'
        ],
        'avatar' => [
            'title' => '头像',
            'type' => 'image',
            'location' => public_path() . '/uploads/images/avatars/',
        ],
        'roles' => [
            'title' => '用户角色',
            'type' => 'relationship',
            'name_field' => 'name',
        ],
    ],

    // 数据过滤
    'filters' => [
        'id' => [
            'title' => '用户ID',
        ],
        'name' => [
            'title' => '用户名'
        ],
        'email' => [
            'title' => '邮箱'
        ],
    ],
];
