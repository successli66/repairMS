-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-04-27 00:16:38
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `repairms`
--

-- --------------------------------------------------------

--
-- 表的结构 `rm_company`
--

CREATE TABLE `rm_company` (
  `id` smallint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID',
  `company_name` varchar(30) NOT NULL COMMENT '公司名称',
  `business` varchar(50) DEFAULT NULL COMMENT '主营业务',
  `address` varchar(35) DEFAULT NULL COMMENT '公司地址',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `descr` text COMMENT '公司描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司';

--
-- 转存表中的数据 `rm_company`
--

INSERT INTO `rm_company` (`id`, `company_name`, `business`, `address`, `phone`, `descr`) VALUES
(002, '交运集团青岛信息科技有限公司', '电子、车载、软件', '崂山区香港东路155号', '', NULL),
(003, '青岛四方长途汽车站', '长途客运', '四方区', '', NULL),
(004, '汽车东站', '客运', '崂山', '', NULL),
(005, '海泊河汽车站', '客运', '四方', '11111111', NULL),
(006, '火车站旅游汽车站', '客运', '市南', '22222222', NULL),
(007, '汽车北站', '客运', '城阳', '333333', NULL),
(008, '莱西汽车站', '客运', '莱西', '444444', NULL),
(009, '即墨', '客运', '即墨', '55555555', NULL),
(010, '黄岛汽车站', '客运', '黄岛', '6666666', NULL),
(011, '胶南汽车站', '客运', '胶南', '777777', NULL),
(012, '胶州汽车站', '客运', '胶州', '8888888', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `rm_department`
--

CREATE TABLE `rm_department` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID',
  `department_name` varchar(20) NOT NULL COMMENT '部门名称',
  `header` smallint(5) UNSIGNED DEFAULT NULL COMMENT '部门负责人',
  `business` varchar(50) DEFAULT NULL COMMENT '业务范围',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `company_id` smallint(5) UNSIGNED NOT NULL COMMENT '公司ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部门';

--
-- 转存表中的数据 `rm_department`
--

INSERT INTO `rm_department` (`id`, `department_name`, `header`, `business`, `phone`, `company_id`) VALUES
(01, '电子工程处', 0, '工程', '666666', 2),
(02, '车载', 0, '车载', '7777777', 2),
(03, '软件', 0, '开发', '', 2),
(04, '客运处', 0, '客运', '', 3);

-- --------------------------------------------------------

--
-- 表的结构 `rm_equipment`
--

CREATE TABLE `rm_equipment` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'ID',
  `equipment_name` varchar(20) NOT NULL COMMENT '设备名称',
  `model` varchar(30) NOT NULL COMMENT '设备型号',
  `serial_number` varchar(30) NOT NULL COMMENT '设备编号',
  `project_id` smallint(5) UNSIGNED NOT NULL COMMENT '所属项目ID',
  `install_date` date DEFAULT NULL COMMENT '安装时间',
  `address` varchar(30) DEFAULT NULL COMMENT '安放地点',
  `descr` text COMMENT '设备描述',
  `manufacturer` varchar(30) DEFAULT NULL COMMENT '厂家',
  `company_id` smallint(5) UNSIGNED NOT NULL COMMENT '安放公司ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设备表';

--
-- 转存表中的数据 `rm_equipment`
--

INSERT INTO `rm_equipment` (`id`, `equipment_name`, `model`, `serial_number`, `project_id`, `install_date`, `address`, `descr`, `manufacturer`, `company_id`) VALUES
(1, '售票机1', 'sdfa', 'sdfwe4', 1, '2017-03-02', '市南', '<p style="text-align:center;"><img src="/ueditor/php/upload/image/20170310/1489135566140808.png" alt="QQ截图20170303125713.png" width="856" height="413" /></p>', '广电', 6),
(3, '售票机2', 'sdfa', '123', 1, '2017-03-01', '市南', '', '广电', 6),
(4, '售票机23', 'sdfazxxcgf', '1225448875', 3, '2017-03-27', '四方区', '', '广电运通', 3);

-- --------------------------------------------------------

--
-- 表的结构 `rm_event`
--

CREATE TABLE `rm_event` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `repair_id` int(10) UNSIGNED NOT NULL COMMENT '报修表ID',
  `event_type` varchar(1) NOT NULL COMMENT '事件类型',
  `event_name` varchar(10) NOT NULL COMMENT '事件名称',
  `event_value` varchar(50) DEFAULT NULL COMMENT '事件值',
  `user_id` smallint(5) UNSIGNED NOT NULL COMMENT '操作人ID',
  `event_time` datetime NOT NULL COMMENT '发生时间',
  `descr` text COMMENT '事件描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='事件表';

--
-- 转存表中的数据 `rm_event`
--

INSERT INTO `rm_event` (`id`, `repair_id`, `event_type`, `event_name`, `event_value`, `user_id`, `event_time`, `descr`) VALUES
(1, 11, '1', '报修', '4,10', 1, '2017-04-27 07:43:47', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `rm_fee`
--

CREATE TABLE `rm_fee` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `repair_id` int(10) UNSIGNED NOT NULL COMMENT '报修表ID',
  `fee_item` varchar(20) NOT NULL COMMENT '收费项',
  `fee` smallint(5) UNSIGNED NOT NULL COMMENT '实际费用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='费用表';

-- --------------------------------------------------------

--
-- 表的结构 `rm_modify`
--

CREATE TABLE `rm_modify` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `modify_item` varchar(50) NOT NULL COMMENT 'repair表中的列名',
  `modify_name` varchar(50) NOT NULL COMMENT '列名说明',
  `origin` varchar(50) NOT NULL COMMENT '原始值',
  `modified` varchar(50) NOT NULL COMMENT '修改后值'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='修改记录表';

-- --------------------------------------------------------

--
-- 表的结构 `rm_part`
--

CREATE TABLE `rm_part` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `part_name` varchar(20) NOT NULL COMMENT '配件名称',
  `model` varchar(30) NOT NULL COMMENT '设备型号',
  `in_price` decimal(10,0) DEFAULT '0' COMMENT '进价',
  `out_price` decimal(10,0) DEFAULT '0' COMMENT '出价',
  `project_id` smallint(5) UNSIGNED NOT NULL COMMENT '所属项目ID',
  `descr` text COMMENT '配件描述',
  `image` varchar(150) DEFAULT NULL COMMENT '图片路径',
  `manufacturer` varchar(30) DEFAULT NULL COMMENT '厂家'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配件表';

--
-- 转存表中的数据 `rm_part`
--

INSERT INTO `rm_part` (`id`, `part_name`, `model`, `in_price`, `out_price`, `project_id`, `descr`, `image`, `manufacturer`) VALUES
(1, '进钞机芯', 'asdfasfd', '2000', '2500', 1, '<p style="text-align:center;"><img src="/ueditor/php/upload/image/20170309/1489017010124482.png" alt="QQ截图20170303125713.png" width="680" height="361" /></p>', NULL, '广电运通');

-- --------------------------------------------------------

--
-- 表的结构 `rm_project`
--

CREATE TABLE `rm_project` (
  `id` smallint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID',
  `project_name` varchar(20) NOT NULL COMMENT '项目名称',
  `department_id` tinyint(3) UNSIGNED NOT NULL COMMENT '所属部门ID',
  `team` varchar(50) NOT NULL COMMENT '项目团队,职员ID逗号隔开',
  `descr` text COMMENT '项目描述',
  `phone` varchar(20) DEFAULT NULL COMMENT '维修电话'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='维修项目';

--
-- 转存表中的数据 `rm_project`
--

INSERT INTO `rm_project` (`id`, `project_name`, `department_id`, `team`, `descr`, `phone`) VALUES
(001, '售票机', 1, '4', NULL, NULL),
(002, '售票机1', 1, '10', '&lt;p&gt;1111111&lt;img src=&quot;/ueditor/php/upload/image/20170303/1488517293583984.png&quot; title=&quot;1488517293583984.png&quot; alt=&quot;QQ截图20170303125713.png&quot;/&gt;&lt;/p&gt;', ''),
(003, '售票机2', 1, '1,4,10', '<p><img src="/ueditor/php/upload/image/20170303/1488528490730249.png" title="1488528490730249.png" alt="QQ截图20170303125713.png"/></p>', ''),
(004, '安检仪', 1, '2,4,10', '<p>&lt;script&gt;alert(&#39;llllll&#39;)&lt;/script&gt;</p>', ''),
(005, '安检仪1', 1, '2,4,10', '<p>&lt;script&gt;alert(&#39;llllll&#39;)&lt;/script&gt;</p>', ''),
(006, '安检仪11', 1, '2,4', '<p><img src="/ueditor/php/upload/image/20170303/1488530186217052.png" title="1488530186217052.png" alt="QQ截图20170303125713.png"/></p>', ''),
(007, 'GPS', 2, '2', '', ''),
(008, '较运行', 3, '2', '<p>法发送到23<img src="/ueditor/php/upload/image/20170304/1488587215531399.png" title="1488587215531399.png" alt="QQ截图20170303125713.png"/></p>', ''),
(009, '微信', 3, '1,2,4,10', '<p>阿<img src="/ueditor/php/upload/image/20170304/1488587562705290.png" title="1488587562705290.png" alt="QQ截图20170303125713.png"/>发送短发散发</p>', ''),
(010, '维修', 2, '1,2,4,10', '<h1 style="font-size: 32px; font-weight: bold; border-bottom: 2px solid rgb(204, 204, 204); padding: 0px 4px 0px 0px; text-align: center; margin: 0px 0px 20px;">维修修</h1><p style="text-align: center;">安检仪</p><p style="text-align: center;">售票机</p><p style="text-align: center;">GPS</p><p style="text-align: center;">监控</p><p style="text-align: center;"><img src="/ueditor/php/upload/image/20170304/1488598369111555.png" title="1488598369111555.png" alt="QQ截图20170303125713.png"/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>', '');

-- --------------------------------------------------------

--
-- 表的结构 `rm_repair`
--

CREATE TABLE `rm_repair` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `title` varchar(20) NOT NULL COMMENT '标题',
  `project_id` smallint(5) UNSIGNED NOT NULL COMMENT '所属项目ID',
  `descr` text COMMENT '问题描述',
  `image` varchar(150) DEFAULT NULL COMMENT '图片路径',
  `equipment_id` varchar(100) DEFAULT NULL COMMENT '设备表ID',
  `report_person_id` smallint(6) DEFAULT NULL COMMENT '报修人ID',
  `report_time` datetime NOT NULL COMMENT '报修时间',
  `address` varchar(30) DEFAULT NULL COMMENT '维修地点',
  `contact` varchar(20) NOT NULL COMMENT '联系人',
  `phone` varchar(20) NOT NULL COMMENT '电话',
  `repair_status` tinyint(3) UNSIGNED NOT NULL COMMENT '维修状态',
  `repair_order` varchar(30) NOT NULL COMMENT '维修单号',
  `company_id` smallint(6) DEFAULT NULL COMMENT '公司ID',
  `serial_number` varchar(200) DEFAULT NULL COMMENT '设备序列号',
  `appointment_time` datetime DEFAULT NULL COMMENT '预约维修时间',
  `repair_time` datetime DEFAULT NULL COMMENT '维修时间',
  `repaired_time` datetime DEFAULT NULL COMMENT '维修完时间',
  `end_time` datetime DEFAULT NULL COMMENT '办结时间',
  `repair_user_id` varchar(20) DEFAULT NULL COMMENT '维修人员ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='报修表';

--
-- 转存表中的数据 `rm_repair`
--

INSERT INTO `rm_repair` (`id`, `title`, `project_id`, `descr`, `image`, `equipment_id`, `report_person_id`, `report_time`, `address`, `contact`, `phone`, `repair_status`, `repair_order`, `company_id`, `serial_number`, `appointment_time`, `repair_time`, `repaired_time`, `end_time`, `repair_user_id`) VALUES
(1, '售票机维修', 1, '&lt;p style=&quot;text-align: center;&quot;&gt;&lt;img src=&quot;/ueditor/php/upload/image/20170418/1492515847307763.png&quot; title=&quot;1492515847307763.png&quot; alt=&quot;QQ截图20170303125713.png&quot; width=&quot;483&quot; height=&quot;406&quot;/&gt;&lt;/p&gt;', NULL, '1,3', NULL, '2017-04-18 19:49:27', '崂山区香港东路155号', '李绅', '18554870865', 4, '0022017041819492772', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '售票机维修', 1, '&lt;p&gt;&lt;img src=&quot;/ueditor/php/upload/image/20170418/1492520385113053.png&quot; title=&quot;1492520385113053.png&quot; alt=&quot;QQ截图20170303125713.png&quot;/&gt;&lt;/p&gt;', NULL, '1', NULL, '2017-04-18 20:59:52', '崂山区香港东路155号', '李绅', '18554870865', 1, '0022017041820595257', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '售票机维修1', 1, '', NULL, '3', NULL, '2017-04-18 21:00:18', '崂山区香港东路155号', '李绅', '18554870865', 2, '0022017041821001887', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '售票机维修2', 1, '', NULL, '1,3', NULL, '2017-04-18 21:00:32', '崂山区香港东路155号', '李绅', '18554870865', 3, '0022017041821003213', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'ANJIANYI', 1, '&lt;p&gt;&lt;img src=&quot;/ueditor/php/upload/image/20170419/1492559802114718.png&quot; title=&quot;1492559802114718.png&quot; alt=&quot;QQ截图20170303125713.png&quot;/&gt;&lt;/p&gt;', NULL, '1,3', NULL, '2017-04-19 07:56:45', '青岛市崂山区香港东路155号', '张三', '123456', 1, '0022017041907564573', NULL, 'sdfwe4,123', NULL, NULL, NULL, NULL, NULL),
(6, '安检仪', 1, '', NULL, '3', NULL, '2017-04-19 07:58:42', '崂山区香港东路155号', '李绅', '18554870865', 1, '0022017041907584253', NULL, '123', NULL, NULL, NULL, NULL, NULL),
(7, 'anjiany', 1, '', NULL, '1,3', 1, '2017-04-19 08:02:35', '崂山区香港东路155号', '李绅', '18554870865', 1, '0022017041908023516', 2, 'sdfwe4,123', NULL, NULL, NULL, NULL, NULL),
(8, '售票机维修', 1, '&lt;p&gt;&lt;img src=&quot;/ueditor/php/upload/image/20170420/1492700975117907.png&quot; title=&quot;1492700975117907.png&quot; alt=&quot;QQ截图20170303125713.png&quot;/&gt;&lt;/p&gt;', NULL, '1', 1, '2017-04-20 23:09:37', '崂山区香港东路155号', '李绅', '18554870865', 1, '0022017042023093773', 2, 'sdfwe4', NULL, NULL, NULL, NULL, NULL),
(9, '售票机维修', 1, '&lt;p&gt;sadfasdfzxssdghjkkll&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;img src=&quot;/ueditor/php/upload/image/20170421/1492731221113892.png&quot; title=&quot;1492731221113892.png&quot; alt=&quot;QQ截图20170303125713.png&quot; width=&quot;639&quot; height=&quot;376&quot;/&gt;&lt;/p&gt;', NULL, '1', 1, '2017-04-21 07:33:56', '崂山区香港东路155号', '李绅', '18554870865', 1, '0022017042107335613', 2, 'sdfwe4', NULL, NULL, NULL, NULL, NULL),
(10, '售票机维修', 1, '<p>1213123</p>', NULL, '3', 1, '2017-04-21 07:35:27', '崂山区香港东路155号', '李绅', '18554870865', 1, '0022017042107352718', 2, '123', NULL, NULL, NULL, NULL, NULL),
(11, '售票机维修', 1, '<p><img src="/ueditor/php/upload/image/20170421/1492731359108397.png" alt="QQ截图20170303125713.png" /></p>', NULL, '1,3', 1, '2017-04-21 07:36:01', '崂山区香港东路155号', '李绅', '18554870865', 2, '0022017042107360192', 2, 'sdfwe4,123', '2017-04-28 07:34:22', NULL, NULL, NULL, '4,10'),
(12, '售票机维修', 3, '', NULL, '4', 1, '2017-04-25 22:42:56', '崂山区香港东路155号', '李绅', '18554870865', 2, '0022017042522425623', 2, '1225448875', '2017-04-28 07:41:10', NULL, NULL, NULL, '1,4,10');

-- --------------------------------------------------------

--
-- 表的结构 `rm_user`
--

CREATE TABLE `rm_user` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'ID',
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `pw` varchar(32) NOT NULL COMMENT '密码',
  `real_name` varchar(10) DEFAULT NULL COMMENT '姓名',
  `work_number` varchar(10) DEFAULT NULL COMMENT '工号',
  `telephone` varchar(11) DEFAULT NULL COMMENT '手机号',
  `portrait` varchar(60) DEFAULT NULL COMMENT '头像',
  `department_id` tinyint(3) UNSIGNED NOT NULL COMMENT '所属部门ID',
  `post` varchar(10) DEFAULT NULL COMMENT '职务',
  `company_id` smallint(5) UNSIGNED NOT NULL COMMENT '公司ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户';

--
-- 转存表中的数据 `rm_user`
--

INSERT INTO `rm_user` (`id`, `username`, `pw`, `real_name`, `work_number`, `telephone`, `portrait`, `department_id`, `post`, `company_id`) VALUES
(1, 'lishen', 'e10adc3949ba59abbe56e057f20f883e', '李绅', '666666', '18554870865', NULL, 1, 'Developer', 2),
(2, 'admin', '96e79218965eb72c92a549dd5a330112', '超级管理员', '', NULL, NULL, 1, NULL, 2),
(4, '111', '111111', '张三', '', '', NULL, 1, NULL, 2),
(9, 'asd1111', '96e79218965eb72c92a549dd5a330112', '1111', '', NULL, NULL, 4, NULL, 3),
(10, '1223123', '96e79218965eb72c92a549dd5a330112', '王五', '', '', NULL, 1, '工程师', 2);

-- --------------------------------------------------------

--
-- 表的结构 `rm_use_part`
--

CREATE TABLE `rm_use_part` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `repair_id` int(10) UNSIGNED NOT NULL COMMENT '报修表ID',
  `part_id` int(10) UNSIGNED NOT NULL COMMENT '配件表ID',
  `use_number` smallint(5) UNSIGNED NOT NULL COMMENT '使用数量',
  `fee_id` smallint(5) UNSIGNED NOT NULL COMMENT '费用表ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配件用量表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rm_company`
--
ALTER TABLE `rm_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `rm_department`
--
ALTER TABLE `rm_department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_name` (`department_name`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `rm_equipment`
--
ALTER TABLE `rm_equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_name` (`equipment_name`),
  ADD KEY `model` (`model`),
  ADD KEY `serial_number` (`serial_number`),
  ADD KEY `install_date` (`install_date`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `manufacturer` (`manufacturer`),
  ADD KEY `address` (`address`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `rm_event`
--
ALTER TABLE `rm_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_id` (`repair_id`);

--
-- Indexes for table `rm_fee`
--
ALTER TABLE `rm_fee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_id` (`repair_id`);

--
-- Indexes for table `rm_modify`
--
ALTER TABLE `rm_modify`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rm_part`
--
ALTER TABLE `rm_part`
  ADD PRIMARY KEY (`id`),
  ADD KEY `part_name` (`part_name`),
  ADD KEY `model` (`model`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `manufacturer` (`manufacturer`);

--
-- Indexes for table `rm_project`
--
ALTER TABLE `rm_project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `team` (`team`);

--
-- Indexes for table `rm_repair`
--
ALTER TABLE `rm_repair`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `report_person` (`report_person_id`),
  ADD KEY `equipment_id` (`equipment_id`),
  ADD KEY `repair_status` (`repair_status`),
  ADD KEY `report_time` (`report_time`),
  ADD KEY `repair_order` (`repair_order`),
  ADD KEY `phone` (`phone`),
  ADD KEY `contact` (`contact`),
  ADD KEY `address` (`address`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `serial_number` (`serial_number`);

--
-- Indexes for table `rm_user`
--
ALTER TABLE `rm_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `real_name` (`real_name`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `rm_use_part`
--
ALTER TABLE `rm_use_part`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_id` (`repair_id`),
  ADD KEY `part_id` (`part_id`),
  ADD KEY `fee_id` (`fee_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `rm_company`
--
ALTER TABLE `rm_company`
  MODIFY `id` smallint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=13;
--
-- 使用表AUTO_INCREMENT `rm_department`
--
ALTER TABLE `rm_department`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `rm_equipment`
--
ALTER TABLE `rm_equipment`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `rm_event`
--
ALTER TABLE `rm_event`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `rm_fee`
--
ALTER TABLE `rm_fee`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- 使用表AUTO_INCREMENT `rm_modify`
--
ALTER TABLE `rm_modify`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- 使用表AUTO_INCREMENT `rm_part`
--
ALTER TABLE `rm_part`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `rm_project`
--
ALTER TABLE `rm_project`
  MODIFY `id` smallint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `rm_repair`
--
ALTER TABLE `rm_repair`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=13;
--
-- 使用表AUTO_INCREMENT `rm_user`
--
ALTER TABLE `rm_user`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `rm_use_part`
--
ALTER TABLE `rm_use_part`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
