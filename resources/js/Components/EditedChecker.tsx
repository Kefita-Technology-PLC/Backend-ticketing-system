import { faCheckCircle } from "@fortawesome/free-solid-svg-icons"
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome"
import dayjs from "dayjs"
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime)

interface Thing{
  created_at: string,
  updated_at: string,
}

interface Date{
  thing: Thing
}

function EditedChecker({thing}: Date) {
  return (
    <>
      {thing.created_at == thing.updated_at ? (
        'No'
      ) : (
        <div className="flex flex-col">
          <span>Edited <FontAwesomeIcon icon={faCheckCircle} className="w-4 ml-1" /></span>
          <span>({dayjs(thing.updated_at).fromNow()})</span>
        </div>
      )} 
    </>
  )
}

export default EditedChecker
