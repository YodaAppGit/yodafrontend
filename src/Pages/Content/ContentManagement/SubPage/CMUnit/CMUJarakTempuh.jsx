import React, { useState, useEffect } from 'react'
import axiosBackend from '../../../../../Helper/axiosBackend'
import { Box } from '@mui/system'
import { DataGrid } from '@mui/x-data-grid'
import { Button, FormControl, InputLabel, OutlinedInput, Popover } from '@mui/material'
import DynamicContentMenu from '../../../../../Components/Menus/DynamicContentMenu'

const INPUTS = [
  { label: 'Jarak tempuh', value: '', error: false, disabled: false,},
]

export default function CMUJarakTempuh(props) {
  const [Data, setData] = useState([])

  useEffect(() => { LoadData() }, [])

  useEffect(() => {
    setMenuAnchorEl(null);
    ResetInputs();
    LoadData();
  }, [props.val]);

  async function LoadData() {
    await axiosBackend.get('/cm/jarak-tempuh')
    .then((response) => { 
      var tempData = response.data
      tempData.forEach((dat, idx) => {
        dat.index = idx + 1;
      });
      setData(tempData)
     })
  }

  const { indexPage, ActiveSubPage } = props
  const { isMenuOpen } = props
  const { MenuanchorEl, setMenuAnchorEl } = props

  const [InputJarakTempuh, setInputJarakTempuh] = useState(INPUTS[0])
  
  function handleSubmit() {
    var isPassed = true;
    // Validation
    if (isPassed) {
      InsertData();
    }
  }

  function ResetInputs() {
    setInputJarakTempuh(INPUTS[0])
  }

  async function InsertData() {
    await axiosBackend.post('/cm/jarak-tempuh', {
      jarak_tempuh: InputJarakTempuh.value,
    })
    .then((response) => {
      console.log(response.data)
      setMenuAnchorEl(null)
      ResetInputs()
      LoadData()
    })
    .catch((err) => { console.warn(err.response) })
  }

  const DATAGRID_COLUMNS = [
    { field: 'index', headerName: '#' },
    { field: 'id', headerName: 'ID', hide: true },
    { field: 'jarak_tempuh', headerName: 'Jarak tempuh unit', minWidth: 180, flex: 1 },
  ]

  
  return (
    <>
      { indexPage!==ActiveSubPage?null:(
        <Popover
          open={isMenuOpen}
          anchorEl={MenuanchorEl}
          onClose={() => setMenuAnchorEl(null) }
          anchorOrigin={{
            vertical: 'bottom',
            horizontal: 'right',
          }}
          transformOrigin={{
            vertical: 'top',
            horizontal: 'right',
          }}
        >
          <DynamicContentMenu
            header={"Tambah baru"}
            actionButtons={
              <>
                <Button size="large" fullWidth variant="contained" onClick={handleSubmit} >Tambah</Button>
              </>
            }
          >
            <FormControl variant="outlined" color="primary" fullWidth error={InputJarakTempuh.error}>
              <InputLabel htmlFor="input-1">{InputJarakTempuh.label}</InputLabel>
              <OutlinedInput
                id="input-1"
                type="text"
                value={InputJarakTempuh.value}
                onChange={(e) => setInputJarakTempuh({...InputJarakTempuh, value: e.target.value})}
                label={InputJarakTempuh.label}
              />
            </FormControl>
            {/* <Autocomplete
              disablePortal
              id="asd1"
              options={top100Films}
              fullWidth
              size="large"
              renderInput={(params) => <TextField {...params} label="Movie" />}
              popupIcon={<ChevronRightIcon />}
            /> */}
          </DynamicContentMenu>
        </Popover>
      ) }
      <Box fullWidth sx={{ maxHeight: '70vh', height: '70vh'}}>
        <DataGrid
          columns={DATAGRID_COLUMNS}
          rows={Data}
          checkboxSelection
          onSelectionModelChange={(newId) => {
            props.changeIcons(newId, "jarak-tempuh")
            console.log(newId);
          }}
          disableColumnResize={false}
          disableSelectionOnClick
        />
      </Box>
    </>
  )
}
