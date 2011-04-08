--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: ab_author; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE ab_author (
    idab_author integer NOT NULL,
    ab_author character varying(120),
    birthdate date,
    photo character varying(500),
    bio text
);

--
-- Name: ab_author_idab_author_seq; Type: SEQUENCE; Schema: public;
--

CREATE SEQUENCE ab_author_idab_author_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

--
-- Name: ab_author_idab_author_seq; Type: SEQUENCE OWNED BY; Schema: public;
--

ALTER SEQUENCE ab_author_idab_author_seq OWNED BY ab_author.idab_author;


--
-- Name: ab_author_idab_author_seq; Type: SEQUENCE SET; Schema: public;
--

SELECT pg_catalog.setval('ab_author_idab_author_seq', 1, false);


--
-- Name: ab_comment; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE ab_comment (
    idab_comment integer NOT NULL,
    idab_entry integer,
    name character varying(180),
    web character varying(200),
    email character varying(300),
    ab_comment text,
    public boolean DEFAULT false,
    sentdate timestamp without time zone DEFAULT now(),
    ip character varying(120)
);


--
-- Name: ab_comment_idab_comment_seq; Type: SEQUENCE; Schema: public;
--

CREATE SEQUENCE ab_comment_idab_comment_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: ab_comment_idab_comment_seq; Type: SEQUENCE OWNED BY; Schema: public;
--

ALTER SEQUENCE ab_comment_idab_comment_seq OWNED BY ab_comment.idab_comment;


--
-- Name: ab_comment_idab_comment_seq; Type: SEQUENCE SET; Schema: public;
--

SELECT pg_catalog.setval('ab_comment_idab_comment_seq', 1, false);


--
-- Name: ab_doc; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE ab_doc (
    idab_doc integer NOT NULL,
    ab_doc character varying(500),
    file character varying(500),
    description text,
    creation timestamp without time zone DEFAULT now()
);


--
-- Name: ab_doc_idab_doc_seq; Type: SEQUENCE; Schema: public;
--

CREATE SEQUENCE ab_doc_idab_doc_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: ab_doc_idab_doc_seq; Type: SEQUENCE OWNED BY; Schema: public;
--

ALTER SEQUENCE ab_doc_idab_doc_seq OWNED BY ab_doc.idab_doc;


--
-- Name: ab_doc_idab_doc_seq; Type: SEQUENCE SET; Schema: public;
--

SELECT pg_catalog.setval('ab_doc_idab_doc_seq', 1, false);


--
-- Name: ab_entry; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE ab_entry (
    idab_entry integer NOT NULL,
    ab_entry character varying(500),
    body text,
    public boolean DEFAULT false,
    creation timestamp without time zone DEFAULT now(),
    read integer DEFAULT 0,
    print integer DEFAULT 0,
    sent integer DEFAULT 0,
    idab_author integer
);


--
-- Name: ab_entry_idab_entry_seq; Type: SEQUENCE; Schema: public;
--

CREATE SEQUENCE ab_entry_idab_entry_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: ab_entry_idab_entry_seq; Type: SEQUENCE OWNED BY; Schema: public;
--

ALTER SEQUENCE ab_entry_idab_entry_seq OWNED BY ab_entry.idab_entry;


--
-- Name: ab_entry_idab_entry_seq; Type: SEQUENCE SET; Schema: public;
--

SELECT pg_catalog.setval('ab_entry_idab_entry_seq', 1, false);


--
-- Name: ab_gallery; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE ab_gallery (
    idab_gallery integer NOT NULL,
    ab_gallery character varying(500),
    body text,
    creation timestamp without time zone DEFAULT now()
);


--
-- Name: ab_gallery_idab_gallery_seq; Type: SEQUENCE; Schema: public;
--

CREATE SEQUENCE ab_gallery_idab_gallery_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: ab_gallery_idab_gallery_seq; Type: SEQUENCE OWNED BY; Schema: public;
--

ALTER SEQUENCE ab_gallery_idab_gallery_seq OWNED BY ab_gallery.idab_gallery;


--
-- Name: ab_gallery_idab_gallery_seq; Type: SEQUENCE SET; Schema: public;
--

SELECT pg_catalog.setval('ab_gallery_idab_gallery_seq', 1, false);


--
-- Name: ab_image; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE ab_image (
    idab_image integer NOT NULL,
    ab_image character varying(200),
    file character varying(500),
    credit character varying(500),
    creation timestamp without time zone DEFAULT now()
);


--
-- Name: ab_image_idab_image_seq; Type: SEQUENCE; Schema: public;
--

CREATE SEQUENCE ab_image_idab_image_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: ab_image_idab_image_seq; Type: SEQUENCE OWNED BY; Schema: public;
--

ALTER SEQUENCE ab_image_idab_image_seq OWNED BY ab_image.idab_image;


--
-- Name: ab_image_idab_image_seq; Type: SEQUENCE SET; Schema: public;
--

SELECT pg_catalog.setval('ab_image_idab_image_seq', 1, false);


--
-- Name: ab_page; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE ab_page (
    idab_page character varying(48) NOT NULL,
    ab_page character varying(500),
    body text,
    menu boolean DEFAULT false,
    orden integer DEFAULT 0
);


--
-- Name: ab_photo; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE ab_photo (
    idab_photo integer NOT NULL,
    idab_gallery integer,
    ab_photo character varying(500),
    image character varying(500),
    creation timestamp without time zone DEFAULT now()
);


--
-- Name: ab_photo_idab_photo_seq; Type: SEQUENCE; Schema: public;
--

CREATE SEQUENCE ab_photo_idab_photo_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: ab_photo_idab_photo_seq; Type: SEQUENCE OWNED BY; Schema: public;
--

ALTER SEQUENCE ab_photo_idab_photo_seq OWNED BY ab_photo.idab_photo;


--
-- Name: ab_photo_idab_photo_seq; Type: SEQUENCE SET; Schema: public;
--

SELECT pg_catalog.setval('ab_photo_idab_photo_seq', 1, false);


--
-- Name: ab_video; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE ab_video (
    idab_video integer NOT NULL,
    ab_video character varying(200),
    url character varying(500),
    credit character varying(500),
    creation timestamp without time zone DEFAULT now()
);


--
-- Name: ab_video_idab_video_seq; Type: SEQUENCE; Schema: public;
--

CREATE SEQUENCE ab_video_idab_video_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: ab_video_idab_video_seq; Type: SEQUENCE OWNED BY; Schema: public;
--

ALTER SEQUENCE ab_video_idab_video_seq OWNED BY ab_video.idab_video;


--
-- Name: ab_video_idab_video_seq; Type: SEQUENCE SET; Schema: public;
--

SELECT pg_catalog.setval('ab_video_idab_video_seq', 1, false);


--
-- Name: idab_author; Type: DEFAULT; Schema: public;
--

ALTER TABLE ab_author ALTER COLUMN idab_author SET DEFAULT nextval('ab_author_idab_author_seq'::regclass);


--
-- Name: idab_comment; Type: DEFAULT; Schema: public;
--

ALTER TABLE ab_comment ALTER COLUMN idab_comment SET DEFAULT nextval('ab_comment_idab_comment_seq'::regclass);


--
-- Name: idab_doc; Type: DEFAULT; Schema: public;
--

ALTER TABLE ab_doc ALTER COLUMN idab_doc SET DEFAULT nextval('ab_doc_idab_doc_seq'::regclass);


--
-- Name: idab_entry; Type: DEFAULT; Schema: public;
--

ALTER TABLE ab_entry ALTER COLUMN idab_entry SET DEFAULT nextval('ab_entry_idab_entry_seq'::regclass);


--
-- Name: idab_gallery; Type: DEFAULT; Schema: public;
--

ALTER TABLE ab_gallery ALTER COLUMN idab_gallery SET DEFAULT nextval('ab_gallery_idab_gallery_seq'::regclass);


--
-- Name: idab_image; Type: DEFAULT; Schema: public;
--

ALTER TABLE ab_image ALTER COLUMN idab_image SET DEFAULT nextval('ab_image_idab_image_seq'::regclass);


--
-- Name: idab_photo; Type: DEFAULT; Schema: public;
--

ALTER TABLE ab_photo ALTER COLUMN idab_photo SET DEFAULT nextval('ab_photo_idab_photo_seq'::regclass);


--
-- Name: idab_video; Type: DEFAULT; Schema: public;
--

ALTER TABLE ab_video ALTER COLUMN idab_video SET DEFAULT nextval('ab_video_idab_video_seq'::regclass);


--
-- Data for Name: ab_author; Type: TABLE DATA; Schema: public; 
--

COPY ab_author (idab_author, ab_author, birthdate, photo, bio) FROM stdin;
\.


--
-- Data for Name: ab_comment; Type: TABLE DATA; Schema: public;
--

COPY ab_comment (idab_comment, idab_entry, name, web, email, ab_comment, public, sentdate, ip) FROM stdin;
\.


--
-- Data for Name: ab_doc; Type: TABLE DATA; Schema: public;
--

COPY ab_doc (idab_doc, ab_doc, file, description, creation) FROM stdin;
\.


--
-- Data for Name: ab_entry; Type: TABLE DATA; Schema: public;
--

COPY ab_entry (idab_entry, ab_entry, body, public, creation, read, print, sent, idab_author) FROM stdin;
\.


--
-- Data for Name: ab_gallery; Type: TABLE DATA; Schema: public;
--

COPY ab_gallery (idab_gallery, ab_gallery, body, creation) FROM stdin;
\.


--
-- Data for Name: ab_image; Type: TABLE DATA; Schema: public;
--

COPY ab_image (idab_image, ab_image, file, credit, creation) FROM stdin;
\.


--
-- Data for Name: ab_page; Type: TABLE DATA; Schema: public;
--

COPY ab_page (idab_page, ab_page, body, menu, orden) FROM stdin;
\.


--
-- Data for Name: ab_photo; Type: TABLE DATA; Schema: public;
--

COPY ab_photo (idab_photo, idab_gallery, ab_photo, image, creation) FROM stdin;
\.


--
-- Data for Name: ab_video; Type: TABLE DATA; Schema: public;
--

COPY ab_video (idab_video, ab_video, url, credit, creation) FROM stdin;
\.


--
-- Name: ab_author_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY ab_author
    ADD CONSTRAINT ab_author_pkey PRIMARY KEY (idab_author);


--
-- Name: ab_comment_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY ab_comment
    ADD CONSTRAINT ab_comment_pkey PRIMARY KEY (idab_comment);


--
-- Name: ab_doc_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY ab_doc
    ADD CONSTRAINT ab_doc_pkey PRIMARY KEY (idab_doc);


--
-- Name: ab_entry_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY ab_entry
    ADD CONSTRAINT ab_entry_pkey PRIMARY KEY (idab_entry);


--
-- Name: ab_gallery_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY ab_gallery
    ADD CONSTRAINT ab_gallery_pkey PRIMARY KEY (idab_gallery);


--
-- Name: ab_image_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY ab_image
    ADD CONSTRAINT ab_image_pkey PRIMARY KEY (idab_image);


--
-- Name: ab_page_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY ab_page
    ADD CONSTRAINT ab_page_pkey PRIMARY KEY (idab_page);


--
-- Name: ab_photo_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY ab_photo
    ADD CONSTRAINT ab_photo_pkey PRIMARY KEY (idab_photo);


--
-- Name: ab_video_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY ab_video
    ADD CONSTRAINT ab_video_pkey PRIMARY KEY (idab_video);


--
-- Name: ab_comment_idab_entry_fkey; Type: FK CONSTRAINT; Schema: public;
--

ALTER TABLE ONLY ab_comment
    ADD CONSTRAINT ab_comment_idab_entry_fkey FOREIGN KEY (idab_entry) REFERENCES ab_entry(idab_entry);


--
-- Name: ab_entry_idab_author_fkey; Type: FK CONSTRAINT; Schema: public;
--

ALTER TABLE ONLY ab_entry
    ADD CONSTRAINT ab_entry_idab_author_fkey FOREIGN KEY (idab_author) REFERENCES ab_author(idab_author);


--
-- Name: ab_photo_idab_gallery_fkey; Type: FK CONSTRAINT; Schema: public;
--

ALTER TABLE ONLY ab_photo
    ADD CONSTRAINT ab_photo_idab_gallery_fkey FOREIGN KEY (idab_gallery) REFERENCES ab_gallery(idab_gallery);


--
-- PostgreSQL database dump complete
--

