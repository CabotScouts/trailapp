import React from 'react';
import { useForm } from '@inertiajs/react';
import Frame, { Container } from '@/layouts/admin/frame';
import Paginator from '@/components/admin/paginator';
import PhotoSubmission from '@/components/photo-submission';
import TextSubmission from '@/components/text-submission';
import { ThumbUpIcon, ThumbDownIcon } from '@heroicons/react/solid';

export default function List({ submissions, children }) {

  const { data, setData, processing, post } = useForm({ id: null });

  const acceptSubmission = (e) => {
    e.preventDefault();
    post(
      route('accept-submission', data.id),
      { preserveScroll: true }
    )
  }

  const rejectSubmission = (e) => {
    e.preventDefault();
    post(
      route('reject-submission', data.id),
      { preserveScroll: true }
    )
  }

  return (
    <Frame title="Submissions">
      {children}

      <Container>
        <div className="mx-auto grid grid-cols-1 md:grid-cols-2">
          {(submissions.data.length > 0) && submissions.data.map((s) =>
            <div key={s.id} className="p-5 border-b border-b-slate-200 border-r border-r-slate-200">
              {s.challenge && <p className="font-serif text-2xl font-bold text-blue-800">{s.challenge}</p>}
              {s.question && <p className="font-serif text-2xl font-bold text-blue-800">{s.question.name}</p>}
              {s.team && <p className="text-sm font-medium">{s.team} ({s.group})</p>}
              {s.question && <p className="test-lg pt-4 italic">{s.question.text}</p>}
              {s.upload && <PhotoSubmission submission={s} />}
              {s.answer && <div className="my-5"><TextSubmission submission={s.answer} /></div>}
              <div className="flex">
                <div className="flex-grow">
                  <p className="text-xs">{s.time}</p>
                </div>
                {(s.accepted === 0) &&
                  <div className="flex-none flex">
                    <form onSubmit={rejectSubmission}>
                      <button type="submit"
                        className="w-8 mr-1 rounded-xl text-center text-neutral-100 font-bold text-sm p-2 bg-orange-600"
                        onClick={(e) => setData('id', s.id)}>
                        <ThumbDownIcon />
                      </button>
                    </form>

                    <form onSubmit={acceptSubmission}>
                      <button type="submit"
                        className="w-8 rounded-xl text-center text-neutral-100 font-bold text-sm p-2 bg-green-600"
                        onClick={(e) => setData('id', s.id)}>
                        <ThumbUpIcon />
                      </button>
                    </form>
                  </div>
                }
              </div>
            </div>
          )}
        </div>
        <Paginator data={submissions} />
        {(submissions.data.length === 0) &&
          <div className="p-5 text-center">
            <p className="text-medium text-xl">No submissions</p>
          </div>
        }
      </Container>
    </Frame>
  )
}
