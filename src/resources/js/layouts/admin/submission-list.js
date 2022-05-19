import React from 'react';
import { useForm } from '@inertiajs/inertia-react';
import Frame from '@/layouts/admin/frame';
import PhotoSubmission from '@/components/photo-submission';
import TextSubmission from '@/components/text-submission';
import { ThumbUpIcon } from '@heroicons/react/solid';

export default function List({ submissions, children }) {

  const { data, setData, processing, post } = useForm({ id: null });

  const acceptSubmission = (e) => {
    e.preventDefault();
    post(
      route('accept-submission', data.id),
      { preserveScroll: true }
    )
  }

  return (
    <Frame title="Submissions">
      { children &&
        <div className="p-3 bg-blue-600 text-neutral-100 text-lg">
          { children }
        </div>
      }
      { (submissions.length > 0) && submissions.map((s) =>
        <div key={ s.id } className="p-5 border border-b-blue-200">
          { s.challenge && <p className="font-serif text-2xl font-bold text-blue-800">{ s.challenge }</p> }
          { s.question && <p className="font-serif text-2xl font-bold text-blue-800">{ s.question.name }</p> }
          { s.team && <p className="text-sm font-medium">{ s.team } ({ s.group })</p> }
          { s.question && <p className="test-lg pt-4 italic">{ s.question.text }</p> }
          { s.file && <PhotoSubmission submission={ s } /> }
          { s.answer && <div className="my-5"><TextSubmission submission={ s.answer } /></div> }
          <div className="flex">
            <div className="flex-grow">
              <p className="text-xs">{ s.time }</p>
            </div>
            { (s.accepted === 0) &&
            <div className="flex-none">
              <form onSubmit={ acceptSubmission }>
                <button type="submit"
                  className="w-8 rounded-xl text-center text-neutral-100 text-medium text-sm p-2 bg-green-600"
                  onClick={ (e) => setData('id', s.id) }>
                  <ThumbUpIcon />
                </button>
              </form>
            </div>
            }
          </div>
        </div>
      ) }
      { (submissions.length === 0) &&
        <div className="p-5 text-center">
          <p className="text-medium text-xl">No submissions</p>
        </div>
      }
    </Frame>
  )
}
