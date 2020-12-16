import PropTypes from 'prop-types'
import styled from 'styled-components/macro'
import { ReactComponent as SearchSvg } from '../Assets/search.svg'
import { useHistory, useLocation } from 'react-router-dom'

export default function SearchButton({ onClick }) {
  SearchButton.propTypes = {
    onClick: PropTypes.func.isRequired,
  }
  const history = useHistory()

  return <SearchSvg onClick={onClick}></SearchSvg>
}
