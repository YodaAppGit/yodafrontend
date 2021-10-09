import React, { useState, useEffect } from "react";
import { Box } from "@mui/system";
import { Button, Collapse, Stack } from "@mui/material";
import Delete from "@mui/icons-material/Delete";
import AddCircleIcon from "@mui/icons-material/AddCircle";
import axiosBackend from "../../../Helper/axiosBackend";

import CMSPenjual from "./SubPage/CMSeller/CMSPenjual";

const top100Films = [
  { label: "The Shawshank Redemption", year: 1994 },
  { label: "The Godfather", year: 1972 },
  { label: "The Godfather: Part II", year: 1974 },
  { label: "The Dark Knight", year: 2008 },
  { label: "12 Angry Men", year: 1957 },
  { label: "Schindler's List", year: 1993 },
  { label: "Pulp Fiction", year: 1994 },
  { label: "The Lord of the Rings: The Return of the King", year: 2003 },
];

export default function CMSeller(props) {
  const [ActiveSubPage, setActiveSubPage] = useState(0);
  const { currentSubTab, dataSort, filteredData } = props;
  const [DeleteButton, setDeleteButton] = useState(false);
  const [DeleteChosenId, setDeleteChosenId] = useState({
    "penjual":[],
  });
  const [DeleteType, setDeleteType] = useState(false);
  const [Deleted, setDeleted] = useState(false);

  const [MenuanchorEl, setMenuAnchorEl] = useState(null);
  const isMenuOpen = Boolean(MenuanchorEl);

  useEffect(() => {
    currentSubTab(0)
  }, [])

  const changeIcons = (val, type) => {
    console.log("masuk sini ");
    setDeleteButton(val.length > 0 ? true : false);
    setDeleteChosenId({...DeleteChosenId, [type]: val});
    setDeleteType(type);
  };

  const multiDelete = async () => {
    await axiosBackend
      .post(`/delete/${DeleteType}`, {
        id: DeleteChosenId[DeleteType],
      })
      .then((response) => {
        setDeleted(!Deleted);
        console.log(response.data);
      })
      .catch((err) => {
        console.warn(err.response);
      });
  };

  const TABS = [
    {
      index: 0,
      label: "Penjual",
      dataGrid: (
        <CMSPenjual
          indexPage={0}
          MenuanchorEl={MenuanchorEl}
          setMenuAnchorEl={setMenuAnchorEl}
          isMenuOpen={isMenuOpen}
          ActiveSubPage={ActiveSubPage}
          dataSort={dataSort}
          filteredData={filteredData}
          changeIcons={changeIcons}
          val={Deleted}
        />
      ),
    },
  ];

  const idxTab = {
    0: "penjual",
  }

  return (
    <>
      <Box sx={{ paddingBottom: 2 }}>
        <Stack direction="row" justifyContent="space-between">
          <Box sx={{ flexGrow: 1 }}>
            {TABS?.map((tab, index) => (
              <Button
                key={index}
                variant="contained"
                size="large"
                color={ActiveSubPage === index ? "mint20" : "grey20"}
                onClick={() => {
                  setActiveSubPage(index);
                  currentSubTab(index);
                  props.cleanFilteredData();
                  setDeleteType(idxTab[index])
                  setDeleteButton(DeleteChosenId[idxTab[index]].length)
                }}
                sx={{ marginRight: 1.5, marginBottom: 1.5 }}
              >
                {tab.label}
              </Button>
            ))}
          </Box>
          <Box>
            {!DeleteButton ? (
              <Button
                variant="contained"
                size="large"
                color="switch"
                startIcon={<AddCircleIcon />}
                onClick={(e) => setMenuAnchorEl(e.currentTarget)}
              >
                {"Tambah"}
              </Button>
            ) : (
              <Button
                size="large"
                variant="outlined"
                color="error"
                startIcon={<Delete />}
                onClick={multiDelete}
              >
                {"Hapus"}
              </Button>
            )}
          </Box>
        </Stack>
      </Box>
      {TABS?.map((tb, index) => (
        <Collapse key={index} in={ActiveSubPage === index} timeout="auto">
          {tb.dataGrid}
        </Collapse>
      ))}
    </>
  );
}
