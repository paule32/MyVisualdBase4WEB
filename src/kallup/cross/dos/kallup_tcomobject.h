// ------------------------------------------------------
// File    : src/cross/kallup_tobject.h
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------
#pragma once
#ifndef __KALLUP_TCOMOBJECT_H__
#define __KALLUP_TCOMOBJECT_H__

# include "kallup_tobject.h"
# include "kallup_objimpl.h"
# include "kallup_io.h"

namespace kallup
{
	namespace windows
	{
		class TComObject: public TComObjectBase {
			friend class TObject;
			std::shared_ptr<Object> object;
			IUnknownImpl<TComObject, IUnknown> unknownImpl;
		public:
			typedef TComObjectBase Base;

			TComObject(std::shared_ptr<TObject> theObject) :
				object(theObject),
				unknownImpl(this) {}

			~TComObject() {
				if(object) {
					object->comObject = nullptr;    
					object            = nullptr;
				}
			}

			template <typename T>
			std::shared_ptr<T> InternalObject() const {
				return object->As<T>();
			}
		};
    };
};

#endif // __KALLUP_TCOMOBJECT_H__
