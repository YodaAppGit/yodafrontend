import React, { useState, useEffect } from "react";
import { Box } from "@mui/system";
import { Button, Collapse, Stack } from "@mui/material";
import AddCircleIcon from "@mui/icons-material/AddCircle";
import CMCKategori from "./SubPage/CMCredit/CMCKategori";
import CMCTipeAsuransi from "./SubPage/CMCredit/CMCTipeAsuransi";
import CMCKesertaanAsuransi from "./SubPage/CMCredit/CMCKesertaanAsuransi";
import CMCNilaiPertanggungan from "./SubPage/CMCredit/CMCNilaiPertanggungan";
import CMCTujuanPenggunaan from "./SubPage/CMCredit/CMCTujuanPenggunaan";
import CMCPembayaranAsuransi from "./SubPage/CMCredit/CMCPembayaranAsuransi";
import CMCTenor from "./SubPage/CMCredit/CMCTenor";
import CMCAngsuranPertama from "./SubPage/CMCredit/CMCAngsuranPertama";
import axiosBackend from "../../../Helper/axiosBackend";
import Delete from "@mui/icons-material/Delete";

export default function CMCredit(props) {
  const [ActiveSubPage, setActiveSubPage] = useState(0);
  const { currentSubTab, dataSort, filteredData } = props;

  const [MenuanchorEl, setMenuAnchorEl] = useState(null);
  const [DeleteButton, setDeleteButton] = useState(false);
  const [DeleteChosenId, setDeleteChosenId] = useState({
    "tujuan-penggunaan":[],
    "kategori":[],
    "tipe-asuransi":[],
    "kesertaan-asuransi":[],
    "nilai-pertanggungan":[],
    "pembayaran-asuransi":[],
    "tenor":[],
    "angsuran-pertama":[],
  });
  const [DeleteType, setDeleteType] = useState(false);
  const [Deleted, setDeleted] = useState(false);
  const isMenuOpen = Boolean(MenuanchorEl);

  useEffect(() => {
    currentSubTab(0);
  }, []);

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
      label: "Tujuan penggunaan",
      dataGrid: (
        <CMCTujuanPenggunaan
          indexPage={0}
          dataSort={dataSort}
          MenuanchorEl={MenuanchorEl}
          setMenuAnchorEl={setMenuAnchorEl}
          isMenuOpen={isMenuOpen}
          ActiveSubPage={ActiveSubPage}
          filteredData={filteredData}
          changeIcons={changeIcons}
          val={Deleted}
        />
      ),
    },
    {
      index: 1,
      label: "Kategori",
      dataGrid: (
        <CMCKategori
          indexPage={1}
          dataSort={dataSort}
          MenuanchorEl={MenuanchorEl}
          setMenuAnchorEl={setMenuAnchorEl}
          isMenuOpen={isMenuOpen}
          ActiveSubPage={ActiveSubPage}
          filteredData={filteredData}
          changeIcons={changeIcons}
          val={Deleted}
        />
      ),
    },
    {
      index: 2,
      label: "Tipe asuransi",
      dataGrid: (
        <CMCTipeAsuransi
          indexPage={2}
          dataSort={dataSort}
          MenuanchorEl={MenuanchorEl}
          setMenuAnchorEl={setMenuAnchorEl}
          isMenuOpen={isMenuOpen}
          ActiveSubPage={ActiveSubPage}
          filteredData={filteredData}
          changeIcons={changeIcons}
          val={Deleted}
        />
      ),
    },
    {
      index: 3,
      label: "Kesertaan Asuransi",
      dataGrid: (
        <CMCKesertaanAsuransi
          indexPage={3}
          dataSort={dataSort}
          MenuanchorEl={MenuanchorEl}
          setMenuAnchorEl={setMenuAnchorEl}
          isMenuOpen={isMenuOpen}
          ActiveSubPage={ActiveSubPage}
          filteredData={filteredData}
          changeIcons={changeIcons}
          val={Deleted}
        />
      ),
    },
    {
      index: 4,
      label: "Nilai pertanggungan",
      dataGrid: (
        <CMCNilaiPertanggungan
          indexPage={4}
          dataSort={dataSort}
          MenuanchorEl={MenuanchorEl}
          setMenuAnchorEl={setMenuAnchorEl}
          isMenuOpen={isMenuOpen}
          ActiveSubPage={ActiveSubPage}
          filteredData={filteredData}
          changeIcons={changeIcons}
          val={Deleted}
        />
      ),
    },
    {
      index: 5,
      label: "Pembayaran asuransi",
      dataGrid: (
        <CMCPembayaranAsuransi
          indexPage={5}
          dataSort={dataSort}
          MenuanchorEl={MenuanchorEl}
          setMenuAnchorEl={setMenuAnchorEl}
          isMenuOpen={isMenuOpen}
          ActiveSubPage={ActiveSubPage}
          filteredData={filteredData}
          changeIcons={changeIcons}
          val={Deleted}
        />
      ),
    },
    {
      index: 6,
      label: "Tenor",
      dataGrid: (
        <CMCTenor
          indexPage={6}
          dataSort={dataSort}
          MenuanchorEl={MenuanchorEl}
          setMenuAnchorEl={setMenuAnchorEl}
          isMenuOpen={isMenuOpen}
          ActiveSubPage={ActiveSubPage}
          filteredData={filteredData}
          changeIcons={changeIcons}
          val={Deleted}
        />
      ),
    },
    {
      index: 7,
      label: "Angsuran pertama",
      dataGrid: (
        <CMCAngsuranPertama
          indexPage={7}
          dataSort={dataSort}
          MenuanchorEl={MenuanchorEl}
          setMenuAnchorEl={setMenuAnchorEl}
          isMenuOpen={isMenuOpen}
          ActiveSubPage={ActiveSubPage}
          filteredData={filteredData}
          changeIcons={changeIcons}
          val={Deleted}
        />
      ),
    },
  ];
  
  const idxTab = {
    0 : "tujuan-penggunaan",
    1 : "kategori",
    2 : "tipe-asuransi",
    3 : "kesertaan-asuransi",
    4 : "nilai-pertanggungan",
    5 : "pembayaran-asuransi",
    6 : "tenor",
    7 : "angsuran-pertama",
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
