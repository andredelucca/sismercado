USE [master]
GO
/****** Object:  User [##MS_PolicyEventProcessingLogin##]    Script Date: 17/06/2024 09:34:21 ******/
CREATE USER [##MS_PolicyEventProcessingLogin##] FOR LOGIN [##MS_PolicyEventProcessingLogin##] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [##MS_AgentSigningCertificate##]    Script Date: 17/06/2024 09:34:21 ******/
CREATE USER [##MS_AgentSigningCertificate##] FOR LOGIN [##MS_AgentSigningCertificate##]
GO
/****** Object:  Schema [mercado]    Script Date: 17/06/2024 09:34:21 ******/
CREATE SCHEMA [mercado]
GO
/****** Object:  Table [mercado].[gerarpedidoid]    Script Date: 17/06/2024 09:34:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [mercado].[gerarpedidoid](
	[pedido_id] [int] IDENTITY(1,1) NOT NULL,
	[data_inclusao] [date] NOT NULL,
 CONSTRAINT [PK_gerarpedidoid] PRIMARY KEY CLUSTERED 
(
	[pedido_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [mercado].[pedido]    Script Date: 17/06/2024 09:34:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [mercado].[pedido](
	[pedido_id] [int] NOT NULL,
	[qtd] [int] NOT NULL,
	[produto] [varchar](255) NOT NULL,
	[valor] [varchar](255) NOT NULL,
	[imposto] [varchar](255) NOT NULL,
	[data_inclusao] [date] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [mercado].[produto]    Script Date: 17/06/2024 09:34:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [mercado].[produto](
	[id_produto] [int] IDENTITY(1,1) NOT NULL,
	[produto] [varchar](255) NOT NULL,
	[descricao] [varchar](255) NULL,
	[tipo_id] [int] NULL,
	[data_inclusao] [date] NOT NULL,
	[preco] [varchar](255) NOT NULL,
 CONSTRAINT [PK_produto] PRIMARY KEY CLUSTERED 
(
	[id_produto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [mercado].[tipo]    Script Date: 17/06/2024 09:34:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [mercado].[tipo](
	[tipo_id] [int] IDENTITY(1,1) NOT NULL,
	[tipo] [varchar](255) NULL,
	[descricao] [varchar](255) NULL,
	[tributacao] [varchar](255) NOT NULL,
	[data_inclusao] [date] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[tipo_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [mercado].[gerarpedidoid] ADD  DEFAULT (getdate()) FOR [data_inclusao]
GO
ALTER TABLE [mercado].[pedido] ADD  DEFAULT (getdate()) FOR [data_inclusao]
GO
ALTER TABLE [mercado].[produto] ADD  DEFAULT (getdate()) FOR [data_inclusao]
GO
ALTER TABLE [mercado].[tipo] ADD  DEFAULT (getdate()) FOR [data_inclusao]
GO
