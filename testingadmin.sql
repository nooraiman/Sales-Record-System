INSERT INTO staff(
    st_id,
    st_username,
    st_password,
    st_name,
    st_email
)
VALUES(
    999,
    "Admin999",
    "58b1216b06850385d9a4eadbedc806c4",
    "Mr. Testing Hensem",
    "testing@mail.com"
);
INSERT INTO role(ro_id, ro_name)
VALUES(1, "Admin");
INSERT INTO login(lo_id, st_id, ro_id)
VALUES(999, 999, 1);
