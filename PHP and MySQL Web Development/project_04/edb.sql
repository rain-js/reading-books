----------------------------------------------------------------
-- MySQL(中医体质辨识系统数据库)
create view vi_reportData as
select ea01.a01001 as "编号",
	ea01.a01027 as "体检号",
	ei03.i03005 as "面色",
	ei03.i03003 as "光泽",
	ei03.i03004 as "唇色",
	substring(ei04.i04003, 3,2) as "舌色",
   ei04.i04017 as "苔色",
	left(ei04.i04005, 1) as "厚薄",
	left(ei04.i04006, 1) as "腻腐",
	left(ei04.i04007, 1) as "苔剥",
	left(ei04.i04008, 4) as "胖瘦",
	left(ei04.i04009, 3) as "齿痕",
	left(ei04.i04010, 3) as "点刺",
	left(ei04.i04011, 3) as "裂纹",
	ei05.i05003 as "左右手",
	ei05.i05005 as "脉位",
	ei05.i05010 as "脉率",
	ei05.i05007 as "脉力",
	ei05.i05004 as "脉名提示",
	em01.m01004 as "评分",
	em01.m01003	as "结果"--体质分类判定结果
	from ea01
	left join ea02 on ea01.a01001 = ea02.a02002
	left join ei03 on ea01.a01001 = ei03.i03002
	left join ei04 on ea01.a01001 = ei04.i04002
	left join ei05 on ea01.a01001 = ei05.i05002
	left join em01 on em01.m01001 = ea02.a02001

	
----------------------------------------------------------------
-- SQL Server(360PEIS系统数据库)
create view vi_edb_report as
select * from openquery(edb_interface, 'select * from vi_reportData')