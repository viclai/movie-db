# Creating tables (with constraints)

CREATE TABLE Movie (
    id int NOT NULL,
    title varchar(100),
    year int,
    rating varchar(10),
    company varchar(50),
    PRIMARY KEY(id) -- id should be unique; uniquely identifies table
);

CREATE TABLE Actor (
    id int NOT NULL,
    last varchar(20),
    first varchar(20),
    sex varchar(6),
    dob date,
    dod date,
    PRIMARY KEY(id), -- id should be unique; uniquely identifies table
    CHECK((sex = 'Female' OR sex = 'Male') AND (DATEDIFF(dob, dod) >= 0)) 
    -- sex should only have 2 options and date of birth should be earlier 
    -- than date of death
);

CREATE TABLE Director (
    id int NOT NULL,
    last varchar(20),
    first varchar(20),
    dob date,
    dod date,
    PRIMARY KEY(id), -- id should be unique; uniquely identifies table
    CHECK(DATEDIFF(dob, dod) >= 0) -- date of birth should be earlier than 
                                   -- date of death
);

CREATE TABLE MovieGenre (
    mid int NOT NULL,
    genre varchar(20) NOT NULL,
    FOREIGN KEY(mid) references Movie(id) -- mid should map to id in Movie
) ENGINE = INNODB;

CREATE TABLE MovieDirector (
    mid int NOT NULL,
    did int NOT NULL,
    FOREIGN KEY(mid) references Movie(id), -- mid should map to id in Movie
    FOREIGN KEY(did) references Director(id) -- did should map to id in
                                             -- Director
) ENGINE = INNODB;

CREATE TABLE MovieActor (
    mid int NOT NULL,
    aid int NOT NULL,
    role varchar(50),
    FOREIGN KEY(mid) references Movie(id), -- mid should map to id in Movie
    FOREIGN KEY(aid) references Actor(id) -- aid should map to id in Actor
) ENGINE = INNODB;

CREATE TABLE Review (
    name varchar(20),
    time timestamp,
    mid int NOT NULL,
    rating int,
    comment varchar(500),
    FOREIGN KEY(mid) references Movie(id) -- mid should map to id in Movie
) ENGINE = INNODB;

CREATE TABLE MaxPersonID (
    id int
);

CREATE TABLE MaxMovieID (
    id int
);
