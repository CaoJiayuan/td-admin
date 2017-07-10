<?php
/**
 * 后台权限配置文件,字段与后台permissions表字段对应
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 上午10:37
 */

return [
  [
    'path'         => '/',
    'name'         => 'dashboard',
    'display_name' => '首页',
    'description'  => '首页',
    'icon'         => 'fa fa-home',
    'node'         => [

    ]
  ],
  [
    'path'         => '#',
    'name'         => 'base',
    'display_name' => '基础内容管理',
    'description'  => '基础内容管理',
    'icon'         => 'fa fa-th-large',
    'node'         => [
//      [
//        'path'         => '/sge',
//        'name'         => 'base.sge',
//        'display_name' => '上金所介绍',
//        'node'         => [
//          [
//            'name'         => 'base.sge.add',
//            'display_name' => '新增目录',
//            'type'         => 1
//          ],
//          [
//            'name'         => 'base.sge.edit',
//            'display_name' => '编辑',
//            'type'         => 1
//          ],
//          [
//            'name'         => 'base.sge.questions',
//            'display_name' => '编辑问题',
//            'type'         => 1,
//            'node'         => [
//              [
//                'name'         => 'base.sge.questions.add',
//                'display_name' => '新增问题',
//                'type'         => 1
//              ],
//              [
//                'name'         => 'base.sge.questions.edit',
//                'display_name' => '编辑问题',
//                'type'         => 1
//              ],
//              [
//                'name'         => 'base.sge.questions.delete',
//                'display_name' => '删除问题',
//                'type'         => 1
//              ],
//            ]
//          ],
//          [
//            'name'         => 'base.sge.delete',
//            'display_name' => '删除',
//            'type'         => 1
//          ],
//        ]
//      ],
      [
        'path'         => '/disclaimer',
        'name'         => 'base.disclaimer',
        'display_name' => '免责声明',
        'node'         => [
          [
            'path'         => '',
            'name'         => 'base.disclaimer.edit',
            'display_name' => '保存',
            'type'         => 1
          ]
        ]
      ],
      [
        'path'         => '/agreement',
        'name'         => 'base.agreement',
        'display_name' => '开户协议',
        'node'         => [
          [
            'name'         => 'base.agreement.add',
            'display_name' => '新增协议',
            'type'         => 1
          ],
          [
            'name'         => 'base.agreement.edit',
            'display_name' => '编辑协议',
            'type'         => 1
          ],
          [
            'name'         => 'base.agreement.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
      [
        'path'         => '/products',
        'name'         => 'base.product',
        'display_name' => '产品管理',
        'node'         => [
          [
            'name'         => 'base.product.add',
            'display_name' => '新增产品',
            'type'         => 1
          ],
          [
            'name'         => 'base.product.edit',
            'display_name' => '编辑产品',
            'type'         => 1
          ],
          [
            'name'         => 'base.product.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
      [
        'path'         => '/leaders',
        'name'         => 'base.group',
        'display_name' => '管理团队',
        'node'         => [
          [
            'path'         => '/leaders/add',
            'name'         => 'base.group.add',
            'display_name' => '新增管理团队',
            'type'         => 1
          ],
          [
            'path'         => '/leaders/edit',
            'name'         => 'base.group.edit',
            'display_name' => '编辑管理团队',
            'type'         => 1
          ],
          [
            'name'         => 'base.group.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
      [
        'path'         => '/recruits',
        'name'         => 'base.join',
        'display_name' => '加入我们',
        'node'         => [
          [
            'path'         => '/recruits/add',
            'name'         => 'base.recruits.add',
            'display_name' => '新增加入我们',
            'type'         => 1
          ],
          [
            'path'         => '/recruits/edit',
            'name'         => 'base.recruits.edit',
            'display_name' => '编辑加入我们',
            'type'         => 1
          ],
          [
            'name'         => 'base.recruits.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
      [
        'path'         => '/contacts',
        'name'         => 'base.contact',
        'display_name' => '联系我们',
        'node'         => [
          [
            'path'         => '/contacts/add',
            'name'         => 'base.contacts.add',
            'display_name' => '新增联系我们',
            'type'         => 1
          ],
          [
            'path'         => '/contacts/edit',
            'name'         => 'base.contacts.edit',
            'display_name' => '编辑联系我们',
            'type'         => 1
          ],
          [
            'name'         => 'base.contacts.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
      [
        'path'         => '/feedback',
        'name'         => 'base.feedback',
        'display_name' => '意见反馈',
      ],
      [
        'path'         => '/product/complaint',
        'name'         => 'base.complaint',
        'display_name' => '评论投诉',
      ],
      [
        'path'         => '/version',
        'name'         => 'base.version',
        'display_name' => '更新管理',
        'node'         => [
          [
            'name'         => 'base.version.add',
            'display_name' => '新增版本',
            'type'         => 1
          ],
          [
            'name'         => 'base.version.edit',
            'display_name' => '编辑版本',
            'type'         => 1
          ],
          [
            'name'         => 'base.version.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
    ]
  ],
  [
    'path'         => '#',
    'name'         => 'news',
    'display_name' => '新闻管理',
    'description'  => '新闻管理',
    'icon'         => 'fa fa-newspaper-o',
    'node'         => [
      [
        'path'         => '/news/info',
        'name'         => 'news.info',
        'display_name' => '新闻资讯',
        'node'         => [
          [
            'name'         => 'news.info.show',
            'display_name' => '查看',
            'type'         => 1
          ],
          [
            'name'         => 'news.info.comments',
            'display_name' => '查看评论',
            'type'         => 1
          ],
        ]
      ],
      [
        'path'         => '/news/flash',
        'name'         => 'news.flash',
        'display_name' => '新闻快讯',
        'node'         => [
          [
            'name'         => 'news.flash.show',
            'display_name' => '查看',
            'type'         => 1
          ],
        ]
      ],
      [
        'path'         => '/news/scoop',
        'name'         => 'news.scoop',
        'display_name' => '独家专栏',
        'node'         => [
          [
            'name'         => 'news.scoop.add',
            'display_name' => '添加专栏',
            'type'         => 1
          ],
          [
            'name'         => 'news.scoop.show',
            'display_name' => '查看',
            'type'         => 1
          ],
          [
            'name'         => 'news.scoop.edit',
            'display_name' => '编辑',
            'type'         => 1
          ],
          [
            'name'         => 'news.scoop.comments',
            'display_name' => '查看评论',
            'type'         => 1
          ],
          [
            'name'         => 'news.scoop.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
      [
        'path'         => '/news/scoopCate',
        'name'         => 'news.scoopCate',
        'display_name' => '独家专栏类别',
        'node'         => [
          [
            'name'         => 'news.scoopCate.add',
            'display_name' => '添加类型',
            'type'         => 1
          ],
          [
            'name'         => 'news.scoopCate.edit',
            'display_name' => '编辑',
            'type'         => 1
          ],
          [
            'name'         => 'news.scoopCate.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ]
    ]
  ],
  [
    'path'         => '#',
    'name'         => 'ads',
    'display_name' => '广告管理',
    'description'  => '广告管理',
    'icon'         => 'fa fa-picture-o',
    'node'         => [
      [
        'path'         => '/adsposition',
        'name'         => 'ads.adsposition',
        'display_name' => '广告位列表',
      ],
      [
        'path'         => '/ads',
        'name'         => 'ads.ads',
        'display_name' => '广告列表',
        'node'         => [
          [
            'path'         => '/ads/add',
            'name'         => 'ads.ads.add',
            'display_name' => '新增广告',
            'type'         => 1
          ],
          [
            'path'         => '/ads/edit',
            'name'         => 'ads.ads.edit',
            'display_name' => '编辑',
            'type'         => 1
          ],
          [
            'name'         => 'ads.ads.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
      [
        'path' => '/notice', 'name' => 'ads.notice', 'display_name' => '推送列表',
        'node' => [
          [
            'path'         => '/notice/add',
            'name'         => 'ads.notice.add',
            'display_name' => '新增推送',
            'type'         => 1
          ],
          [
            'path'         => '/notice/edit',
            'name'         => 'ads.notice.edit',
            'display_name' => '编辑',
            'type'         => 1
          ],
          [
            'name'         => 'ads.notice.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
          [
            'name'         => 'ads.notice.publish',
            'display_name' => '发布',
            'type'         => 1
          ]
        ]
      ],
      [
        'path' => '/resources', 'name' => 'ads.resources', 'display_name' => '素材列表',
        'node' => [
          [
            'name'         => 'ads.resources.show',
            'display_name' => '预览',
            'type'         => 1
          ],
          [
            'path'         => '/resources/add',
            'name'         => 'ads.resources.add',
            'display_name' => '新增素材',
            'type'         => 1
          ],
          [
            'path'         => '/resources/edit',
            'name'         => 'ads.resources.edit',
            'display_name' => '编辑',
            'type'         => 1
          ],
          [
            'name'         => 'ads.resources.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
    ]
  ],
  [
    'path'         => '#',
    'name'         => 'account',
    'display_name' => '客户管理',
    'description'  => '客户管理',
    'icon'         => 'fa fa-users',
    'node'         => [
      [
        'path'         => '/account',
        'name'         => 'account.account',
        'display_name' => '客户列表',
        'node'         => [
          [
            'name'         => 'account.account.debits',
            'display_name' => '账户详情',
            'type'         => 1
          ],
          [
            'name'         => 'account.account.transfers',
            'display_name' => '转账明细',
            'type'         => 1
          ],
          [
            'name'         => 'account.account.capital',
            'display_name' => '资金流水',
            'type'         => 1
          ],
          [
            'name'         => 'account.account.setBroker',
            'display_name' => '分配客户经理',
            'type'         => 1
          ]
        ]
      ],
      [
        'path'         => '/broker',
        'name'         => 'account.broker',
        'display_name' => '客户经理列表',
        'node'         => [
          [
            'name'         => 'account.broker.add',
            'display_name' => '新增客户经理',
            'type'         => 1
          ],
          [
            'name'         => 'account.broker.edit',
            'display_name' => '编辑',
            'type'         => 1
          ],
          [
            'name'         => 'account.broker.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
      [
        'path'         => '/service',
        'name'         => 'account.service',
        'display_name' => '客服列表',
        'node'         => [
            [
                'name'         => 'account.service.add',
                'display_name' => '新增客服',
                'type'         => 1
            ],
            [
                'name'         => 'account.service.edit',
                'display_name' => '编辑',
                'type'         => 1
            ],
            [
                'name'         => 'account.service.delete',
                'display_name' => '删除',
                'type'         => 1
            ],
        ]
      ],
      [
        'path' => '/branch', 'name' => 'account.branch', 'display_name' => '单位列表',
        'node' => [
          [
            'name'         => 'account.branch.add',
            'display_name' => '新增单位',
            'type'         => 1
          ],
          [
            'name'         => 'account.branch.edit',
            'display_name' => '编辑',
            'type'         => 1
          ],
          [
            'name'         => 'account.branch.delete',
            'display_name' => '删除',
            'type'         => 1
          ],
        ]
      ],
    ]
  ],
  [
    'path'         => '#',
    'name'         => 'role',
    'display_name' => '用户管理',
    'description'  => '用户管理',
    'icon'         => 'fa fa-user',
    'node'         => [
      [
        'path'         => '/role',
        'name'         => 'role.role',
        'display_name' => '角色配置',
        'node'         => [
          [
            'name'         => 'role.role.add',
            'display_name' => '添加角色',
            'type'         => 1
          ],
          [
            'name'         => 'role.role.edit',
            'display_name' => '编辑角色',
            'type'         => 1
          ],
          [
            'name'         => 'role.role.delete',
            'display_name' => '删除角色',
            'type'         => 1
          ]
        ]
      ],
      [
        'path'         => '/admin',
        'name'         => 'role.admin',
        'display_name' => '用户列表',
        'node'         => [
          [
            'name'         => 'role.admin.add',
            'display_name' => '添加用户',
            'type'         => 1
          ],
          [
            'name'         => 'role.admin.edit',
            'display_name' => '编辑用户',
            'type'         => 1
          ],
          [
            'name'         => 'role.admin.delete',
            'display_name' => '删除用户',
            'type'         => 1
          ]
        ]
      ],
    ]
  ],
  [
    'path'         => '#',
    'name'         => 'stat',
    'display_name' => '报表统计',
    'description'  => '报表统计',
    'icon'         => 'fa fa-paper-plane',
    'node'         => [
      [
        'path'         => '/onlinestat',
        'name'         => 'stat.online',
        'display_name' => '在线人数统计',
        'node'         => [
          [
            'name'         => 'stat.online.query',
            'display_name' => '查询',
            'type'         => 1
          ],
          [
            'name'         => 'stat.online.export',
            'display_name' => '导出',
            'type'         => 1
          ]
        ]
      ],
      [
        'path'         => '/registerstat',
        'name'         => 'stat.register',
        'display_name' => '注册人数统计',
        'node'         => [
          [
            'name'         => 'stat.register.query',
            'display_name' => '查询',
            'type'         => 1
          ],
          [
            'name'         => 'stat.register.export',
            'display_name' => '导出',
            'type'         => 1
          ]
        ]
      ],
      [
        'path'         => '/openstat',
        'name'         => 'stat.open',
        'display_name' => '开户人数统计',
        'node'         => [
          [
            'name'         => 'stat.open.query',
            'display_name' => '查询',
            'type'         => 1
          ],
          [
            'name'         => 'stat.open.export',
            'display_name' => '导出',
            'type'         => 1
          ]
        ]
      ],
      [
        'path'         => '/transstat',
        'name'         => 'stat.trans',
        'display_name' => '交易人数统计',
        'node'         => [
          [
            'name'         => 'stat.trans.query',
            'display_name' => '查询',
            'type'         => 1
          ],
          [
            'name'         => 'stat.trans.export',
            'display_name' => '导出',
            'type'         => 1
          ]
        ]
      ],
    ]
  ],
  [
        'path'         => '#',
        'name'         => 'tarde',
        'display_name' => '交易统计',
        'description'  => '交易统计',
        'icon'         => 'fa fa-paper-plane',
        'node'         => [
            [
                'path'         => '/currenttrade',
                'name'         => 'tarde.currenttrade',
                'display_name' => '当日交易查询',
                'node'         => [
                    [
                        'name'         => 'tarde.currenttrade.query',
                        'display_name' => '查询',
                        'type'         => 1
                    ],
                    [
                        'name'         => 'tarde.currenttrade.export',
                        'display_name' => '导出',
                        'type'         => 1
                    ]
                ]
            ],
            [
                'path'         => '/historytrade',
                'name'         => 'tarde.historytrade',
                'display_name' => '历史交易查询',
                'node'         => [
                    [
                        'name'         => 'tarde.historytrade.query',
                        'display_name' => '查询',
                        'type'         => 1
                    ],
                    [
                        'name'         => 'tarde.historytrade.export',
                        'display_name' => '导出',
                        'type'         => 1
                    ]
                ]
            ]
        ]
  ],
  [
        'path'         => '#',
        'name'         => 'assets',
        'display_name' => '资产统计',
        'description'  => '资产统计',
        'icon'         => 'fa fa-paper-plane',
        'node'         => [
            [
                'path'         => '/totalassets',
                'name'         => 'assets.totalassets',
                'display_name' => '总资金查询',
                'node'         => [
                    [
                        'name'         => 'assets.totalassets.query',
                        'display_name' => '查询',
                        'type'         => 1
                    ],
                    [
                        'name'         => 'assets.totalassets.export',
                        'display_name' => '导出',
                        'type'         => 1
                    ]
                ]
            ],
            [
                'path'         => '/currentassets',
                'name'         => 'assets.currentassets',
                'display_name' => '当日出入金',
                'node'         => [
                    [
                        'name'         => 'assets.currentassets.query',
                        'display_name' => '查询',
                        'type'         => 1
                    ],
                    [
                        'name'         => 'assets.currentassets.export',
                        'display_name' => '导出',
                        'type'         => 1
                    ]
                ]
            ],
            [
                'path'         => '/historyassets',
                'name'         => 'assets.historyassets',
                'display_name' => '历史出入金',
                'node'         => [
                    [
                        'name'         => 'assets.historyassets.query',
                        'display_name' => '查询',
                        'type'         => 1
                    ],
                    [
                        'name'         => 'assets.historyassets.export',
                        'display_name' => '导出',
                        'type'         => 1
                    ]
                ]
            ]
        ]
  ]
];